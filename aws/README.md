# MaisonProof central API — AWS low-cost deployment

This is a working **prototype architecture**, not a certified production authentication service. Publishing creates a **pending** submission; an independent authorized reviewer must make a decision. The API does not determine authenticity from product metadata alone.

## Deploy
1. Create an AWS account with MFA, a budget alert, and least-privilege deployment credentials. Install AWS CLI and AWS SAM CLI.
2. From `aws/`, run `sam build` then `sam deploy --guided`. Choose a region close to customers. Supply random independent secrets of at least 32 characters for `StoreKey` and `ReviewerKey`; use an exact storefront origin for `AllowedOrigin`.
3. Save the `ApiUrl` output. Configure this URL, a store identifier, and the same StoreKey in WordPress and Magento integration settings. **Do not expose StoreKey to storefront JavaScript.**
4. Confirm `POST /v1/submissions` returns `202 pending`, and `GET /v1/records/{id}` returns pending. Verify reviewer-only decision requests and that invalid signatures are rejected.
5. Keep reviewer credentials outside merchant systems. A reviewer may POST `{"status":"verified","reviewer":"reviewer-id","evidence_reference":"internal-case-id"}` to `/v1/records/{id}/decision` with `x-mp-reviewer-key` header. This is a bootstrap-only administrative endpoint; move to Cognito/OIDC, MFA, role separation, and immutable audit storage before real customer use.

## Cost and operations
HTTP API + Lambda ARM 128 MB + DynamoDB on-demand has no always-on EC2 instance. Low volume may fit AWS free tiers depending on account eligibility, region, request counts, storage, and retention. **No fixed price or savings guarantee.** Use AWS Pricing Calculator and Cost Explorer. DynamoDB point-in-time recovery adds charges; remove only after an explicit risk decision. Set budgets, CloudWatch alarms, reserved concurrency, WAF or throttling, and lifecycle/retention policies.

## Security and release gates
- Store HMAC signing is timestamp-bound (5 minutes), but idempotency is not a full replay-prevention system. Rotate secrets and use a dedicated secret per tenant before production.
- Reviewer API key is a prototype control; not a production identity and authorization system.
- The two DynamoDB writes on submission are not transactional; add transactions and reconciliation before production. State changes currently do not synchronize submission dedupe row.
- Public status API intentionally excludes evidence and private reviewer information.
- Add tenant isolation, per-store key management, structured evidence intake (private S3), malware scanning, reviewer workflow, immutable audit logs, privacy controls, backups, monitoring, load tests, and disaster recovery.
- Never call a product authentic based only on a seller publishing it. Require actual independent verification.
- Run `python -m compileall aws/service` and deploy to a non-production AWS account; integration tests against live WordPress and Magento installations remain required.

## Request signing
Canonical message: `timestamp + "\n" + store_id + "\n" + raw_json_body`; `x-mp-signature` is lowercase hex HMAC-SHA256 with StoreKey. `x-mp-timestamp` is Unix seconds. Include `idempotency-key`, `x-mp-store`, and `content-type: application/json`.

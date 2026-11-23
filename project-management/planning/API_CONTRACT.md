# Proposed API contract (design only)
`POST /v1/cases` authenticated merchant → case ID, item ID, route, pending status.
`POST /v1/cases/{id}/evidence` presigned upload with file type/size restrictions and scan result.
`POST /v1/cases/{id}/messages` merchant/reviewer thread, immutable timestamps.
`POST /v1/cases/{id}/shipments/quote` returns available carriers, insurance options, exclusions and pricing (only when integrated).
`POST /v1/reviewer/cases/{id}/decision` reviewer-only, idempotent, reason, evidence refs, decision scope.
`GET /v1/public/verify/{certificate_id}` redacted, signed status, issuer, item binding, scope, method, issue/expiry, revocation state.
`GET /v1/storefront/status?merchant=...&item=...` short-lived signed response; never trust client-provided status.
`POST /v1/admin/certificates/{id}/revoke` privileged, audited; immediate cache invalidation.
Common errors: 400 invalid input; 401/403 role; 404 masked unknown record; 409 state conflict; 422 insufficient evidence; 429 rate limit; 503 fail closed. Add OpenAPI schemas before implementation.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **API_CONTRACT-01:** Version /v1 endpoints for merchant submission, record status, evidence upload, review decision, revocation and certificate verification. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-02:** Require merchant identity, idempotency key, replay window, HMAC/JWT validation, schema limits and tenant binding. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-03:** Define webhook signatures: Shopify raw-body HMAC, WooCommerce signing, Magento server-to-server credentials. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-04:** Return consistent 202 pending, 400 validation, 401 auth, 403 tenant, 409 conflict, 429 throttle, 5xx retryable semantics. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-05:** Document signed status webhooks, reconciliation pulls, monotonic revision and certificate revocation behavior. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-06:** Product boundary and target merchant personas. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-07:** Functional behavior and exception paths. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-08:** Cross-platform event and status contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-09:** Evidence, AI triage and independent review. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-10:** Nonfunctional SLOs, privacy and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **API_CONTRACT-11:** Delivery milestones, owners and exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

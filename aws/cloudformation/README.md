# MaisonProof AWS CloudFormation deployment

## What is actually deployed

A production-oriented **baseline**, not a certified enterprise service: HTTP API Gateway, two ARM64 Python Lambda functions, DynamoDB with point-in-time recovery, SQS with dead-letter queue, private versioned S3 evidence bucket, IAM least-privilege roles, Cognito JWT authorizer for reviewer decisions, throttling and CloudWatch alarms. Submission uses HMAC signing and transactional idempotency. Records start `pending`; **nothing automatically authenticates an item**. API Gateway JWT verification plus an application reviewer-group check protects decisions.

## Prerequisites

1. Configure AWS CLI credentials, billing alerts, and a deployment region. Install Python 3.12 and AWS CLI v2.
2. Create a **private** S3 artifact bucket. Block public access.
3. Create a Secrets Manager secret containing a random 32+ character HMAC signing string. Set the **same** secret on each connected merchant plugin. This is a single-key MVP: rotate carefully; per-merchant keys and key versions are required for strong multi-tenancy.
4. Create a Cognito user pool and app client for reviewer authentication (authorization-code + PKCE). Create the `MaisonProofReviewers` group and assign only authorized reviewers. Set MFA required, and secure account recovery. Provide the user pool ID and app client ID to the stack. API Gateway validates JWT issuer and audience; the app checks group membership. Configure and test tokens before reviewer access.
5. Set `ALLOWED_ORIGIN` to the trusted browser origin. Server-to-server plugins do not require CORS. Configure DNS and TLS/custom domain separately if needed.
6. Export `AWS_REGION`, `ARTIFACT_BUCKET`, `STORE_SIGNING_SECRET_ARN`, `REVIEWER_POOL_ID`, `REVIEWER_APP_CLIENT_ID`, `ALLOWED_ORIGIN`, then run `bash aws/cloudformation/deploy.sh` from repository root.
7. Use the stack output API URL in both plugins. Confirm signing payload compatibility with the plugin request body and timestamp. Test on staging before production.

## Security and operational acceptance

- Verify signature failures, five-minute clock skew, idempotent retries, invalid status transitions, group authorization, audit entries, queue DLQ alerts, no public S3 access, encryption at rest and TLS.
- Enable account-wide CloudTrail and AWS Budgets outside this stack. Configure log retention, secret rotation, AWS Backup/restore drills, alert destinations and incident response.
- For public launches add per-merchant secrets/tenant isolation, reconciliation for failed SQS enqueue, webhook callbacks, evidence upload presigned URLs with content scanning, reviewer interface, appeal workflow, stronger anti-replay controls, structured logging and load/security tests.
- If using WAF, custom domain, Route 53, CloudFront, enhanced support, or NAT/VPC endpoints, budget separately. They are deliberately excluded from the lowest-idle-cost baseline.
- Do not represent this as having passed an audit, penetration test, SLA, or external authentication certification.

## Cost model

Pay-per-request DynamoDB, API Gateway HTTP API, Lambda and SQS minimize idle compute. Fixed/recurring costs may still include Secrets Manager, S3 storage, CloudWatch logs/alarms, optional Cognito usage, and any custom domains. Actual AWS pricing varies by region and usage. Use AWS Pricing Calculator and AWS Budgets before launch; no universal monthly price is guaranteed.

## Plugin compatibility

Existing WordPress/Magento integrations sign requests with `timestamp + newline + store + newline + raw body`, matching this API. The API status response intentionally exposes only ID/status/timestamp. `GET /v1/records/{id}` does not authenticate storefront identity: do not expose confidential product or customer data here. Storefront badges must not show verified until central review. Magento observer and WordPress sync require staging integration tests, queue/retry hardening, and platform-specific security reviews.

## Known limitations

This template references an **existing** Cognito pool and artifact bucket; they are prerequisites, not created by the stack. The asynchronous worker currently marks queued receipt only; it is not a review engine. SQS enqueue failure after transaction is logged but needs reconciliation. Reviewer group parsing and JWT claims must be tested with actual Cognito tokens. No claim of fully enterprise-complete functionality is made.

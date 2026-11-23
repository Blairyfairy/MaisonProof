# MaisonProof multi-platform rollout

## Common contract
WooCommerce and Magento send authenticated, idempotent product submissions to `/v1/submissions`; Shopify uses the platform-native signed webhook `/v1/shopify/webhook`. All create **pending** records only. Reviewer JWT plus explicit role and evidence controls govern transitions. Public lookup must fail closed, never show verified without central authorization.

## Competitive roadmap
1. Tenant isolation and merchant-specific credentials, rotation, replay protection, per-tenant throttling.
2. Reconciliation worker and bidirectional status sync for all three platforms, including revocation.
3. Secure evidence ingestion, chain of custody, audit ledger, provenance and independent verification URL.
4. Optional AI-assisted image quality checks and evidence prioritization, with confidence thresholds and human review; no unsupported counterfeit accuracy claims.
5. Device/NFC provenance and anti-cloning design only after independent threat modeling and pilot validation.
6. Load testing, security testing, independent accuracy evaluation, legal/privacy controls and third-party review.

## AWS recommended tiers
- **Lean:** one region, API Gateway HTTP API, ARM64 Lambda, DynamoDB on-demand + PITR, SQS/DLQ, S3 private versioned, Cognito, Secrets Manager, CloudWatch alarms. No NAT/EC2 required.
- **Growth:** isolate tenants, enforce quotas, add WAF if risk warrants, CloudTrail/data events selectively, alarms and budget alerts, AWS Backup and tested restoration, optional Step Functions for multi-stage evidence review.
- **Enterprise:** evaluate multi-account separation, dedicated KMS keys, regional DR, security hub/GuardDuty, immutable evidence controls, SSO and penetration testing based on contractual requirements and cost.

**Current boundaries:** This package is a working scaffold, not an audited authentication product. Shopify OAuth/metafield sync and AI inference are specified but not implemented; WooCommerce/Magento require installation testing. AWS deployment and pricing have not been validated in a live account.

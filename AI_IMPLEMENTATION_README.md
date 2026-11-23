# MaisonProof AI evidence update

## Implemented

- Reviewer-JWT-protected `POST /v1/records/{id}/evidence-upload` returns a five-minute S3 presigned PUT URL. Upload with exactly the requested Content-Type.
- Private evidence bucket emits S3 Object Created events through EventBridge → encrypted SQS → Lambda.
- Evidence worker hashes images, stores advisory evidence rows in DynamoDB and optionally calls Amazon Bedrock vision. `EnableBedrock=false` by default to avoid unexpected inference charges.
- Reviewer remains the sole authority for verification; automated results cannot set `verified`.
- Sprint 00–12 acceptance gates expanded.

## Deployment additions

Build `evidence-ai.zip` with `evidence_ai.py` at ZIP root and upload to the private artifact bucket at `maisonproof/evidence-ai.zip`. Deploy `production.yaml` with `EvidenceAiArtifactKey`, `EnableBedrock` and `BedrockModelId`. Existing `deploy.sh` may need the additional ZIP upload step. Ensure model availability and model access in the chosen AWS Region before enabling Bedrock.

## Critical production blockers

1. Presigned S3 PUT does not itself enforce an 8 MiB upload cap; add S3 upload policy/edge controls and quarantine/scan untrusted files before production. The worker rejects oversized content, but objects can still be uploaded.
2. Confirm EventBridge S3 notification configuration does not conflict with other bucket notification configuration.
3. Use tenant-specific credentials and server-authoritative badge/status publication, never merchant-editable metafields as proof.
4. Build Shopify OAuth, app installation, privacy compliance, status sync and uninstall handling.
5. Implement async WooCommerce and Magento retries and verify permissions in real installs.
6. Add expert-labeled datasets, independent model validation, threat testing, retention/deletion and audit controls.
7. Verify CloudFormation changes with `aws cloudformation validate-template`, deploy to staging and run integration/security tests.

**No production or competitor-beating claims are made by this update.**

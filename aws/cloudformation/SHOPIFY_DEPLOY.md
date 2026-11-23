# Shopify CloudFormation extension

Build `shopify-webhook.zip` with `shopify_webhook.py` at the ZIP root and upload to the existing artifact bucket at the `ShopifyArtifactKey` location. Provision a separate Secrets Manager secret containing the Shopify app client secret. Set `ShopifySecretArn`, `ShopifyAllowedShops`, and `ShopifyArtifactKey` when deploying `production.yaml`. Configure Shopify webhook URL using the deployed API URL + `/v1/shopify/webhook`.

The webhook handler validates Shopify's raw-body HMAC before any writes, restricts shop domains, and deduplicates by webhook ID. Shopify webhook delivery retries and central queue reconciliation still require operational tests. Never use an unverified product webhook as proof of authenticity.

**AWS costs:** HTTP API, ARM64 Lambda, on-demand DynamoDB, SQS and S3 are usage-based; CloudWatch, Secrets Manager, data transfer, Cognito, and optional WAF add charges. Estimate costs with AWS Pricing Calculator for expected traffic and region. For higher availability use multi-region disaster recovery only when justified by RTO/RPO; avoid always-on NAT/EC2 at low volumes. Introduce Bedrock for evidence triage only after measuring quality/cost; no foundation model can independently guarantee product authenticity.

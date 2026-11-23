#!/usr/bin/env bash
set -euo pipefail
: "${ARTIFACT_BUCKET:?Set ARTIFACT_BUCKET to an existing private S3 bucket}"
: "${STORE_SIGNING_SECRET_ARN:?Set STORE_SIGNING_SECRET_ARN}"
: "${REVIEWER_POOL_ID:?Set REVIEWER_POOL_ID}"
: "${REVIEWER_APP_CLIENT_ID:?Set REVIEWER_APP_CLIENT_ID}"
: "${ALLOWED_ORIGIN:?Set ALLOWED_ORIGIN}"
: "${AWS_REGION:?Set AWS_REGION}"
cd "$(dirname "$0")"
python3 -m zipfile -c /tmp/mp-api.zip app.py
python3 -m zipfile -c /tmp/mp-worker.zip worker.py
aws s3 cp /tmp/mp-api.zip "s3://${ARTIFACT_BUCKET}/maisonproof/api.zip" --region "$AWS_REGION"
aws s3 cp /tmp/mp-worker.zip "s3://${ARTIFACT_BUCKET}/maisonproof/worker.zip" --region "$AWS_REGION"
aws cloudformation deploy --region "$AWS_REGION" --stack-name maisonproof-production --template-file production.yaml --capabilities CAPABILITY_IAM --parameter-overrides "ArtifactBucket=${ARTIFACT_BUCKET}" "StoreSigningSecretArn=${STORE_SIGNING_SECRET_ARN}" "ReviewerUserPoolId=${REVIEWER_POOL_ID}" "ReviewerAppClientId=${REVIEWER_APP_CLIENT_ID}" "AllowedOrigin=${ALLOWED_ORIGIN}"
aws cloudformation describe-stacks --region "$AWS_REGION" --stack-name maisonproof-production --query 'Stacks[0].Outputs' --output table

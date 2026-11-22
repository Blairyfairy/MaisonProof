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

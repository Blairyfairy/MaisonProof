# Target architecture (not current code)
```mermaid
flowchart LR
M[Merchant portal] --> API[Authenticated API]
API --> CASE[Case & evidence service]
CASE --> REVIEW[Reviewer console]
REVIEW --> SIGN[Approval signing service]
SIGN --> CERT[Certificate & revocation registry]
CERT --> VERIFY[Public verification API]
VERIFY --> W[WooCommerce]
VERIFY --> S[Shopify]
VERIFY --> A[Adobe Commerce]
CASE --> STORE[Encrypted object storage]
CASE --> AUDIT[Append-only audit events]
CASE --> SHIP[Shipping / insurance partners]
```
Trust boundaries: merchant JWT cannot call approval endpoints; reviewer decisions require separate role, audit and potentially dual approval; public responses redact personal data; verify signatures and item IDs server-side. Fail closed if status unavailable; never cache an authenticated response beyond revocation SLA. Shipping integrations are conditional on signed agreements.

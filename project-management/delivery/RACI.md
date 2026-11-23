# Responsibility matrix
R = responsible, A = accountable, C = consulted, I = informed. Role assignments are proposed.
| Deliverable | PM | Product | Trust lead | Engineering | Design | Security/Legal | Ops |
|---|---|---|---|---|---|---|---|
| Charter/plan | R | A | C | C | C | C | I |
| UX/research | C | A | C | C | R | C | I |
| Authentication standards | C | C | A/R | C | I | C | R |
| Approval API and badges | C | A | C | R | C | C | I |
| Privacy/insurance compliance | C | I | C | C | I | A/R | R |
| Vendor shipping integration | R | A | C | C | I | C | R |
| Pilot launch | R | A | R | R | R | R | R |


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **RACI-01:** Assign accountable owners for platform adapters, AWS API, security, evidence operations, AI evaluation and support. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-02:** Require independent reviewer approval for verification decisions and compliance signoff for insurance claims. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-03:** Named accountable owner and dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-04:** Shopify installation, scopes and webhooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-05:** WooCommerce publish/update/retry flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-06:** Magento observers, queue and admin ACL. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-07:** AWS asynchronous processing and DLQ. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RACI-08:** Evidence-backed acceptance and rollback. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

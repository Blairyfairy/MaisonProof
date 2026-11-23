# Decision log
| ID | Decision | Status | Owner | Rationale / follow-up |
|---|---|---|---|---|
| D-01 | MaisonProof owns final approval; merchant cannot self-certify | Agreed concept | Product/Trust | implement reviewer authority |
| D-02 | Shipment with disclosed insurance options OR guided remote review | Agreed concept | Product/Ops | confirm partners and legal terms |
| D-03 | Green badge only for live item-specific approval | Agreed concept | Security/Product | signed and revocation-aware status |
| D-04 | WooCommerce pilot first; Shopify/Magento staged | Proposed | PM | validate merchant demand |
| D-05 | Public record exposes non-sensitive audit summary | Proposed | Legal/Security | privacy review |
| D-06 | Remote approval category-specific, physical escalation allowed | Proposed | Trust | validate expert policy |


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **DECISIONS-01:** Record decision ID, date, alternatives, tradeoffs, approver and reversal trigger. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-02:** Keep AWS serverless as default, Bedrock opt-in, human final authority and no merchant-issued verified status. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-03:** Document why non-AWS specialist authentication is an optional future integration rather than current capability. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-04:** Product boundary and target merchant personas. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-05:** Functional behavior and exception paths. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-06:** Cross-platform event and status contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-07:** Evidence, AI triage and independent review. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-08:** Nonfunctional SLOs, privacy and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DECISIONS-09:** Delivery milestones, owners and exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

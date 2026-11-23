# Release and go/no-go checklist
- [ ] Legal entity, domain and trademark clearance confirmed
- [ ] Qualified authentication personnel and published SOP operating
- [ ] Secure reviewer permissions, second approval for high-risk cases
- [ ] Signed item-bound certificate, live public lookup, revocation tested
- [ ] Seller cannot self-certify or override badge
- [ ] Shipping and insurance partners contracted; accurate terms displayed
- [ ] Recording consent, retention, privacy notices and deletion procedures approved
- [ ] Payment, refunds, disputes, tax and billing tested
- [ ] Platform policy and app reviews completed where required
- [ ] Pen test, accessibility audit, load tests, restore drill passed
- [ ] Monitoring, incident/on-call, support escalation and SLO dashboard staffed
- [ ] Merchant pilot feedback and unit economics reviewed
- [ ] Founder/Product/Trust/Security/Legal/Ops sign go/no-go decision
**Rollback:** disable badge rendering or revoke affected certificates, roll back adapters, preserve audit logs, notify affected merchants.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **RELEASE_CHECKLIST-01:** Require staging deployment, rollback, secrets review, vulnerability scan and tested backups. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-02:** Run real Shopify, WooCommerce and Magento install/uninstall, sync, retry and revocation tests. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-03:** Block release on unverified AI claims, missing independent review or unresolved critical security risks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-04:** Unit, contract and negative-path testing. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-05:** Three-platform integration test fixtures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-06:** Security, tenant isolation and webhook replay. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-07:** Image abuse, malware and upload size limits. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-08:** AI evaluation and human override. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RELEASE_CHECKLIST-09:** Performance, accessibility and release gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

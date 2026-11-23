# Test strategy and definition of done
Levels: unit, integration, contract, end-to-end, security, accessibility, performance, disaster recovery, platform-specific acceptance, human-review process QA.
Must test: seller spoofed approval; wrong item ID; duplicate certificate; revoked status with stale cache; expired signature; denied/partial remote evidence; video consent revoked; carrier loss; insurance excluded item; API outage fail closed; reviewer conflict; merchant cross-tenant access; XSS in public notes.
DoD per story: approved design, accessible responsive UI, automated tests, audit events, threat assessment, docs, demo, acceptance by product owner and relevant trust/security leads.
Pilot exit: zero known critical defects, revocation works in each adapter, manual reviewer audit passes, support/incident coverage ready, claims approved by counsel.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **TEST_STRATEGY-01:** Unit test signature validation, tenant authorization, idempotency and status transitions. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-02:** Contract test API error schemas, webhook payloads, retries and certificate signature verification. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-03:** Load test p95 lookup and queue backlog; independently test AI false accept/reject and calibration. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-04:** Unit, contract and negative-path testing. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-05:** Three-platform integration test fixtures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-06:** Security, tenant isolation and webhook replay. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-07:** Image abuse, malware and upload size limits. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-08:** AI evaluation and human override. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TEST_STRATEGY-09:** Performance, accessibility and release gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

# Moderated usability test
Tasks: (1) merchant submits item, (2) selects shipment with coverage details, (3) uploads prior certificate for remote review, (4) responds to reviewer request, (5) buyer checks live verification, (6) merchant sees a revoked badge disappear.
Success: correct route selection; insurance terms understood; no assumption that uploaded certificate is already approved; correct badge interpretation; keyboard navigation; error recovery.
Measures: task success, time, misinterpretation, SUS or SEQ, accessibility issues. 5 participants per round for formative tests; test each merchant platform and mobile breakpoint. Consent before any recording.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **USABILITY_TEST-01:** Test merchant install, evidence capture, review decision, customer lookup and revoked badge understanding. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-02:** Collect task success, time on task, error severity, SUS and accessibility observations. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-03:** Recruitment across three commerce platforms. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-04:** Product listing and evidence capture usability. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-05:** Reviewer consistency and false-acceptance risk. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-06:** Badge trust and customer comprehension. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-07:** Accessibility and mobile flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **USABILITY_TEST-08:** Consent, sampling bias and analysis. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

# Customer support playbook
Queues: merchant onboarding, evidence requests, shipping incident, certificate dispute, payment, privacy deletion, accessibility.
Severity 1: forged/incorrect active seal or PII breach → disable affected records, incident lead immediately, preserve evidence, notify per law.
Severity 2: shipment lost/damaged → open carrier/insurer case, preserve custody timeline, communicate coverage without guarantee.
Severity 3: routine review delay → status update and escalation to reviewer.
Templates should state case ID, current status, what is required, expected next update, and contact route; never disclose private evidence on public verification pages.
Review response-time targets are proposals until staffed and measured.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SUPPORT_PLAYBOOK-01:** Create merchant onboarding, retry, missing badge, duplicate product, evidence upload and revoked record playbooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-02:** Define severity matrix, escalation, customer communications, SLA and evidence retention. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-03:** Merchant onboarding and credential rotation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-04:** Intake, evidence upload and custody controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-05:** AI advisory triage and expert adjudication. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-06:** Status sync, revocation and public lookup. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-07:** Escalation, incident and support procedures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SUPPORT_PLAYBOOK-08:** Retention, deletion, audit and recovery. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

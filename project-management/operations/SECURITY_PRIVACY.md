# Security and privacy workstream
Threat model: merchant forging approvals, certificate replay, duplicate item mapping, compromised reviewer account, malicious uploads, leaked video/serials, API enumeration, stale badge cache, forged domain, insider abuse.
Controls: role separation, phishing-resistant MFA, signed approvals and key rotation, HSM/KMS, audit events, rate limits, WAF, upload AV, content validation, encryption, consent logging, minimal public payloads, retention and deletion workflows, breach response, vendor DPA and security reviews.
Privacy deliverables: data map, legal basis, recording consent by jurisdiction, retention schedule, DSAR procedure, processor inventory, cross-border transfer review, privacy notice, DPIA as applicable.
Launch gate: external penetration test, dependency/SBOM scan, incident tabletop, backup restore test, secrets audit, security sign-off.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SECURITY_PRIVACY-01:** Validate webhook signatures on raw request bytes and enforce timestamp/replay and tenant isolation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-02:** Use S3 private encryption, malware scan, bounded uploads, retention, DSAR workflows and least-privilege IAM. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-03:** Document Cognito reviewer MFA, secret rotation, rate limits, WAF decision and incident runbooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-04:** Merchant onboarding and credential rotation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-05:** Intake, evidence upload and custody controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-06:** AI advisory triage and expert adjudication. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-07:** Status sync, revocation and public lookup. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-08:** Escalation, incident and support procedures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SECURITY_PRIVACY-09:** Retention, deletion, audit and recovery. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

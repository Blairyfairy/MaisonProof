# Authentication operations SOP (proposed)
1. Intake item identity and merchant ownership/consent; flag duplicate serials and conflicts.
2. Select shipment or remote; route by brand/category/risk; disclose scope and method limitations.
3. Collect evidence with timestamps, hashes, reviewer identity, and chain of custody (physical or digital).
4. Reviewer checks construction, material, markings, provenance and independent documentation appropriate to category; avoid implying access to manufacturer records without agreement.
5. Request additional photos/video/live guidance or escalate to shipment when insufficient.
6. Conflict-of-interest check and second reviewer for high-value/high-risk; record rationale and limitations.
7. Decision: authenticated, declined, inconclusive, needs more evidence, disputed, revoked. Only authenticated may produce live green seal.
8. Certificate issued by controlled signing key with immutable ID, scope, method, issue/expiry, item binding; public record omits sensitive owner information.
9. Appeals and disputes go to a separate reviewer; revocation takes priority over any cached status.
**No guarantee:** A professional opinion based on available evidence has limits; publish terms, liability scope, and escalation policy before service launch.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **AUTHENTICATION_OPERATIONS-01:** Define product intake → pending → evidence requested → triage → expert review → verified/rejected/inconclusive. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-02:** Handle dispute, expiration, revoked and re-review as explicit transitions. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-03:** Restrict approval to reviewer service; require reason codes and immutable audit events. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-04:** Merchant onboarding and credential rotation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-05:** Intake, evidence upload and custody controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-06:** AI advisory triage and expert adjudication. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-07:** Status sync, revocation and public lookup. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-08:** Escalation, incident and support procedures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **AUTHENTICATION_OPERATIONS-09:** Retention, deletion, audit and recovery. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

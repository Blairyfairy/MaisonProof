# Product requirements document (PRD)
## Personas / jobs
Merchant owner: submit inventory, track review, show trustworthy badges without changing checkout. Reviewer: evaluate evidence and request more. Buyer: confirm live approval and limitations. Ops: manage chain of custody and disputes. Admin: revoke compromised records.
## Core journeys
1. Merchant registers and verifies identity; maps storefront products to physical item IDs.
2. Merchant chooses **shipment** (quote, insurance choice, tracking, intake, custody, inspection, return) or **remote** (photos, existing certificates, optional consented video, chat, iterative requests).
3. Reviewer sees immutable case timeline, evidence, conflict checks and scope; requests additional evidence or escalates to physical review.
4. Independent second check for high-risk categories; reviewer approves, declines, or marks inconclusive with reason.
5. Approval service issues signed, time-bound, item-bound record. Badge adapter fetches status; only approved + valid + item match renders green check.
6. Buyer opens public verification record with non-sensitive scope and limitations. Revocation/dispute immediately disables badge.
## Functional requirements
- FR01 multi-tenant RBAC and merchant verification; FR02 item identity and anti-duplicate checks; FR03 route selection; FR04 shipment quote and insured/approved coverage selection; FR05 tracking and chain of custody; FR06 secure uploads with malware scanning; FR07 recorded video consent and retention; FR08 threaded reviewer requests; FR09 reviewer decision with conflict-of-interest controls; FR10 signed certificate, revocation and public lookup; FR11 plugin verification (WooCommerce first, then Shopify and Magento); FR12 billing/refunds; FR13 audit logs and support; FR14 accessibility and localization readiness.
## Nonfunctional
- Public lookup target 99.9% monthly uptime after launch (SLO proposal); p95 verification status under 500 ms server-side under target load (validate); secrets managed centrally; encryption in transit/at rest; WCAG 2.2 AA target; GDPR/CCPA assessment; privacy retention policy; observability and incident response.
## Acceptance rules
- Green badge **never** on pending/rejected/inconclusive/revoked/disputed/expired/unmatched items.
- Certificate verification independently validates signature, issuer, item binding, expiry and revocation.
- Merchant cannot create or alter reviewer approval via storefront credentials.
- Shipping insurance wording names actual underwriter/carrier and coverage limits only after agreements are signed.
- Remote-only result states method and limitations; reviewer may require shipment.
## Open questions
Qualified review criteria by product category; external authenticator accreditation; custody facilities; insured value ceilings; recording jurisdictions; Shopify distribution method; brand/trademark review; domain ownership.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **PRD-01:** Implement Shopify OAuth install, scopes, mandatory compliance webhooks, product lifecycle and uninstall cleanup. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-02:** Implement WooCommerce secure settings, async publish/update retries, status display and error recovery. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-03:** Implement Magento admin ACL/config encryption, async product events, queue retries and storefront badges. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-04:** Support evidence uploads, hash/quality checks, reviewer queues, disputes, revocations and audit trails. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-05:** Require signed certificates and independent public status lookup; never equate image quality with authenticity. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-06:** Product boundary and target merchant personas. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-07:** Functional behavior and exception paths. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-08:** Cross-platform event and status contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-09:** Evidence, AI triage and independent review. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-10:** Nonfunctional SLOs, privacy and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **PRD-11:** Delivery milestones, owners and exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

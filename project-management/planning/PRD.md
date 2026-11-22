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

# Project charter
**Mission:** give independent luxury merchants a credible item-level authentication service on their existing storefronts without routing sales through a marketplace.
**Sponsor:** founder (assign); **PM:** unassigned; **Product owner:** unassigned; **Trust/Authentication lead:** qualified hire required.
**Problem:** counterfeit risk and weak merchant trust; **hypothesis:** item-specific independent authentication may improve confidence and sales.
**Goals:** launch a narrow pilot with an operational approval workflow, public verification records, and one reliable storefront plugin before broadening to Shopify and Magento.
**In scope:** merchant onboarding, shipment or remote case intake, expert review, evidence requests, audit trail, certificate lifecycle, verified badge, merchant billing, consent, security, QA and analytics.
**Out of scope MVP:** universal manufacturer database, guaranteed authenticity, fully automated image-only certification, proprietary insurance underwriting, resale marketplace, blockchain requirement, broad global rollout.
**Non-negotiables:** reviewer independence, seller cannot self-approve, no green badge without current decision, signed approvals and revocation checks, insurance terms disclosed before purchase, accessible design, protected PII.
**Success gates:** pilot with qualified reviewers; zero known unauthorized green badge activations; demonstrable revocation propagation; complete review audit trail; legal approval of marketing claims; merchant pilot satisfaction and measured unit economics.
**Assumptions to validate:** reviewer availability, acceptable remote-review accuracy by category, insurability, merchant willingness to pay, platform review rules, conversion lift.
**Change control:** PM logs scope changes with impact on trust, cost, delivery and acceptance; sponsor + product + security/trust leads approve material changes.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **CHARTER-01:** Define objective as evidence-based product verification, not guaranteed counterfeit detection. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-02:** Record three-platform scope and AWS-only baseline with optional external technologies documented but not required. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-03:** Name merchant, reviewer, compliance, security and support stakeholders and decision authority. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-04:** Set launch gates for signed certificate verification, privacy review, recovery drills and independently measured model quality. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-05:** Product boundary and target merchant personas. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-06:** Functional behavior and exception paths. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-07:** Cross-platform event and status contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-08:** Evidence, AI triage and independent review. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-09:** Nonfunctional SLOs, privacy and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **CHARTER-10:** Delivery milestones, owners and exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

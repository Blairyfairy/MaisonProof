# Go-to-market plan
**Beachhead:** independent U.S. luxury accessories resellers with existing WooCommerce shops and small high-value catalogs. Avoid promising every luxury category at launch.
**Positioning:** independent item-specific authentication that follows the merchant's own storefront; not a marketplace and not manufacturer endorsement.
**Acquisition:** direct outreach to specialty merchants, industry events, vetted partners, case studies from consented pilots, platform extension directories after approvals.
**Sales:** discovery → risk/ROI estimate → pilot contract → merchant onboarding → 5–20 reviews → results review → subscription expansion.
**Claims policy:** no unverified trust metrics, manufacturer endorsements, insurance guarantees or accuracy percentages.
**Pricing tests:** per-case only vs subscription + case, turnaround tiers, enterprise volume; measure contribution margin and retention.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **GO_TO_MARKET-01:** Position as interoperable verification workflow, not proven AI counterfeit detection. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-02:** Plan merchant pilots across Shopify, WooCommerce and Magento with measured conversion and trust outcomes. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-03:** Prohibit unsupported accuracy, insurance or competitor-superiority marketing claims. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-04:** Merchant segments and differentiated positioning. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-05:** Platform distribution and conversion funnel. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-06:** Unit economics and Bedrock inference budget. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-07:** Reviewer labor, dispute and chargeback costs. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-08:** Legal claims, insurance and evidence limits. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **GO_TO_MARKET-09:** Pilot evidence, pricing and commercial exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

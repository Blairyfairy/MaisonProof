# MaisonProof authentication routes — product specification

**MaisonProof is the final certifying brand.** The two routes are different ways to collect and review evidence; neither is an automatic authentication. The green storefront seal is an approval indicator, not a submission indicator.

## Route 1 — Shipment-based physical inspection with insurance options
1. Merchant creates an item-specific case, chooses shipment-based inspection, and supplies photos, declared value and item details.
2. Portal offers shipment instructions and **built-in insurance or approved external insurance options** where actually available, with transparent carrier eligibility, insured value, coverage terms, exclusions, deductibles and claims process. Never imply coverage is active before confirmed purchase or policy acceptance. The starter has no shipping or insurance integrations.
3. Generate tracked shipping/return instructions and document handoffs, tamper-evident packaging, arrival condition and chain of custody. Inspector records photos, construction, materials, identifiers, findings and any conflicting evidence.
4. A qualified MaisonProof reviewer evaluates the inspection report and supporting evidence, requests more information if needed, and makes the final decision.
5. Arrange insured return shipment according to the selected coverage and carrier terms. An approved decision produces a product-bound MaisonProof verification record; all other decisions leave the seal off.

## Route 2 — Remote guided review, including existing authentication
1. Merchant creates an item-specific case, selects remote review, and may upload an **existing authentication certificate** as evidence.
2. MaisonProof checks the certificate's issuer, provenance, validity, item match and any revocation or conflict. An uploaded certificate alone cannot activate the seal.
3. Reviewer may request close-up images, timestamped video, a live video appointment, real-time chat, or a series of secure follow-up messages and evidence submissions.
4. Each request and response must be timestamped and linked to the case. Video recording requires explicit consent; secure access, retention limits, and deletion policies are mandatory in production.
5. Reviewer may require shipment-based physical inspection when remote methods cannot reliably establish authenticity. Unresolved or inadequate evidence means no approval.
6. MaisonProof issues the final item-specific decision and activates the seal only after all approval checks pass.

## State model
`submitted → intake → awaiting_evidence ↔ under_review → approved | rejected | inconclusive`

`under_review → physical_inspection_required → under_review` (after documented shipment and actual inspection).

`approved → suspended | revoked` (badge deactivates). The starter `api/cases.py` is an in-memory **domain model only**, not a functioning portal or a secure decision service.

## Storefront behavior
- Product image bottom-right: green checkmark with `Vetted by MaisonProof` **only** for current active approved records.
- Hover/focus: `View MaisonProof verification record`; click opens item-specific page on a MaisonProof-controlled HTTPS domain.
- Pending, unverified, rejected, inconclusive, suspended, disputed, revoked and API-unreachable: no green authenticated badge.
- Merchants cannot approve items by changing a metafield or uploading evidence. Storefront checks must rely on trusted MaisonProof backend responses; production needs signed records and robust cache invalidation.

## Required production components (not yet built)
Authenticated merchant portal; case ownership and authorization; expert reviewer portal; shipping label generation; insured shipping quotes and coverage confirmation; tracking; chain-of-custody and return logistics; secure uploads; malware scanning; consented video/live chat; message threads; notification and audit trails; encrypted evidence storage; reviewer credential validation; item-binding and counterfeit checks; conflict/revocation monitoring; digitally signed decisions; privacy, appeals and dispute handling; verified domain, API hosting and platform deployment.

## Important limitations
No real product has been authenticated by this repository. The image is illustrative. No brand partnerships, carrier or insurer integrations, operating inspection facilities, video provider, live chat, certificate verification integration, or domain ownership are established by these files. Production should not claim manufacturer endorsement or that all goods can be authenticated remotely.

## Shipment insurance and custody controls (planned)
Coverage is not automatically included merely by submitting a case. Present a quote or approved proof of external coverage, insured amount, named insurer, transit legs covered (outbound and return), exclusions, claims contact and policy confirmation before the customer ships. Maintain tracking events, condition photos, package identifiers and receipt signatures. If coverage cannot be verified, do not display “insured” as an active status. These controls are requirements, not working integrations.

# MaisonProof — Brand-Issued Authentication Standard

## What MaisonProof sells
MaisonProof is the **authentication service and certifying brand**, not merely a directory of outside certificates. Sellers submit products and supporting documentation to MaisonProof. **MaisonProof conducts and owns the authentication decision** under its published review standard. Only after MaisonProof has completed its checks and explicitly approved that specific item does the MaisonProof authentication seal light up on a connected storefront.

The MaisonProof seal represents a **MaisonProof-issued conclusion**, supported by a traceable chain of evidence. It does not imply the manufacturer endorses MaisonProof, and it does not promise infallibility.

## MaisonProof-controlled approval process
1. **Submit:** merchant applies for authentication and provides the exact item's identifying details, photos, documentation and physical inspection access if required. Submission does not activate a seal.
2. **Establish identity:** MaisonProof determines whether the evidence is sufficiently tied to the particular physical item; serial numbers, receipts, NFC and QR tags are corroborating inputs, not proof by themselves.
3. **Check authorities:** MaisonProof checks brand-controlled records where available, authorized channels, provenance, recognized third-party findings, counterfeit indicators, and conflicts. Do not claim brand partnerships that do not exist.
4. **Perform authentication review:** a qualified MaisonProof reviewer (and physical inspection or specialist escalation where needed) documents a conclusion, sources, confidence, limitations and conflicts. Some products cannot be reliably authenticated remotely.
5. **MaisonProof decision:** MaisonProof independently approves or rejects the case. An outside authenticator's report is evidence, not an automatic seal authorization. A product-bound, audited MaisonProof decision record is required.
6. **Activate storefront seal:** the storefront plugin queries the MaisonProof-controlled verification service and displays the **MaisonProof Authenticated** seal only if the exact record has an active, approved MaisonProof decision. Otherwise it displays no authentication seal.
7. **Maintain and revoke:** MaisonProof may suspend or revoke an approval when evidence changes, fraud is discovered or a dispute is unresolved. Storefronts must recheck status and not cache a permanent approval.

## Non-negotiable trust boundary
Merchants cannot activate the authentication seal by setting a metafield, entering a certificate ID, uploading a receipt, changing JavaScript or asserting approval. The plugin must consult MaisonProof's trusted backend. Review credentials, approval decisions, and verification records must be controlled and auditable by MaisonProof. Production deployment needs real reviewer authentication, secure storage, evidence validation, domain control, and fraud/revocation operations.

## Public claim
**MaisonProof Authenticated** means: "MaisonProof reviewed this specific item using its documented authentication standard and issued an active authentication decision. View the evidence basis, scope, date, and limitations."

## Prototype limitations
The starter implements a *policy gate*, not a live authentication operation. Reviewer flags in the sample are placeholders; production must create them only through authenticated, audited MaisonProof internal workflows. There are no live brand integrations, verified reviewers, domain registration, or real issued approvals in this starter.

## Intake routes and reviewer correspondence

MaisonProof intends to offer (1) shipment-based physical inspection with built-in or approved insurance options where available and (2) remote guided review. Remote cases may involve existing certificate validation, live video, consented recordings, secure uploads, reviewer chat, and iterative evidence requests. Both routes end with a MaisonProof-controlled item-specific decision. Third-party certificates never automatically activate the badge. Insufficient remote evidence escalates to shipment-based physical inspection or a non-approved outcome. Shipment requires tracking, documented chain of custody, secure intake, return handling and insurance terms disclosed and confirmed before coverage is represented as active. Preserve a privacy-conscious audit trail; obtain appropriate recording consent and define retention and access controls before launching. These are proposed workflows, not implemented operational services.


## Shipment-based vs remote decision basis
A qualified MaisonProof reviewer may approve an item based on a documented, item-bound **shipment-based physical inspection by MaisonProof** or on sufficiently verified external authentication evidence plus MaisonProof review. The independent MaisonProof decision is required in either case. The prototype policy module represents these with `maisonproof_inspection` or `evidence` plus `maisonproof_approval`; these are trusted-backend assertions, **not checks performed automatically by this code**. See [WORKFLOWS.md](WORKFLOWS.md).

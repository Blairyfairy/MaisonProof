# Optional AI enhancements beyond AWS (documentation only)

The deployable implementation uses AWS services only. No external AI dependency is required.

## Optional alternatives — do not enable without evaluation

- **Dedicated vision model provider**: add an adapter behind `EvidenceAnalyzer` for image embeddings and visual anomaly screening. Compare calibrated false-accept rates, latency, price, data residency, and licensing against Bedrock; do not replace expert decisions automatically.
- **Specialist authenticity hardware / microscopic imaging**: for materially stronger physical verification, use authenticated capture devices, NFC secure elements, or tamper-evident serial provenance. These require vendor contracts and physical chain-of-custody; a photograph alone cannot prove genuineness.
- **Third-party expert review**: human specialists can adjudicate uncertain cases and generate a gold-standard dataset. Contractual data handling and audit evidence are mandatory.
- **Independent model evaluation**: external testing lab for genuine/counterfeit reference samples, adversarial robustness, false acceptance/rejection, and drift.

## Portability contract

Keep the central record states (`pending`, `in_review`, `verified`, `rejected`, `revoked`) and event schema stable. Place optional external inference behind a new `analyze_evidence` adapter returning `quality`, `issues`, `model_version`, `review_required`; never allow an adapter to set `verified`. Feature flags and fallback to manual review are required.

## Current limitations

AWS Bedrock vision triage is advisory only. This package does not contain a trained counterfeit classifier, validated accuracy, Shopify OAuth/token lifecycle, cryptographically signed public certificates, or completed end-to-end platform tests.

# Shipment and insurance operations plan
Workflow: quote → declared value → choose eligible built-in or approved third-party policy → show underwriter, covered events, exclusions, limits, deductible and claims rules → customer acceptance → tamper-evident label → pickup → tracking → receiving photo/video → custody scan → expert inspection → secure return → delivery confirmation.
**Partner selection:** verify licensing and coverage, high-value limits, geography, loss claims, API capabilities, secure facilities, packaging standards, return coverage, dispute handling.
**Controls:** dual custody handoff, photo evidence, parcel weight, exception alerts, segregated storage, loss incident runbook, clear responsibility for declared value and claims.
**MVP fallback:** manually arranged shipping with approved insured service and explicit human review; no UI promise of automatic insurance until integration exists.
**Operational KPIs:** transit losses, claims closure time, intake SLA, handling cost, inspection time, customer disputes.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SHIPPING_INSURANCE-01:** Keep shipping/insurance optional and avoid unsupported coverage claims. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-02:** Document chain of custody, declared values, exclusions, loss evidence and carrier/underwriter contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-03:** Merchant onboarding and credential rotation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-04:** Intake, evidence upload and custody controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-05:** AI advisory triage and expert adjudication. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-06:** Status sync, revocation and public lookup. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-07:** Escalation, incident and support procedures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SHIPPING_INSURANCE-08:** Retention, deletion, audit and recovery. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

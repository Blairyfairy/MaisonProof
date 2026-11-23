# Analytics plan
North-star: valid authentications shown to shoppers per active merchant, with quality safeguards.
Funnel: merchant invited → connected → item submitted → evidence complete → review started → decision issued → badge shown → verification viewed → purchase conversion measured.
Events: `merchant_connected`, `case_created`, `route_selected`, `shipment_quoted`, `shipment_received`, `evidence_uploaded`, `reviewer_requested_more`, `decision_recorded`, `certificate_revoked`, `badge_rendered`, `verification_opened`.
Properties: tenant_id (pseudonymous), item_id, route, category, status, elapsed_hours, platform, experiment_arm. Never send raw certificates, customer names, serials, recordings or PII to general analytics.
Guardrails: false-positive rate, dispute rate, revocation latency, consent compliance, reviewer QA, net unit contribution. Conversion lift requires randomized or carefully matched comparisons, not assumptions from infographic.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **ANALYTICS-01:** Define event taxonomy: submission_accepted, evidence_uploaded, triage_completed, review_decided, badge_synced, lookup_opened, dispute_opened. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-02:** Tag every event with tenant_id, platform, record_id, trace_id, event_time and schema_version; exclude PII. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-03:** Measure funnel by platform, evidence rejection rate, review SLA, verification turnaround, certificate lookup success. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-04:** Report model drift, human override, false accept/reject using independently labeled sets; never present advisory score as authenticity. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-05:** Instrument API Gateway/Lambda/SQS latency, DLQ depth, retry rates and Bedrock cost by tenant. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-06:** Product boundary and target merchant personas. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-07:** Functional behavior and exception paths. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-08:** Cross-platform event and status contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-09:** Evidence, AI triage and independent review. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-10:** Nonfunctional SLOs, privacy and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ANALYTICS-11:** Delivery milestones, owners and exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

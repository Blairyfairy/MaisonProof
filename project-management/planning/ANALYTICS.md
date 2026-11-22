# Analytics plan
North-star: valid authentications shown to shoppers per active merchant, with quality safeguards.
Funnel: merchant invited → connected → item submitted → evidence complete → review started → decision issued → badge shown → verification viewed → purchase conversion measured.
Events: `merchant_connected`, `case_created`, `route_selected`, `shipment_quoted`, `shipment_received`, `evidence_uploaded`, `reviewer_requested_more`, `decision_recorded`, `certificate_revoked`, `badge_rendered`, `verification_opened`.
Properties: tenant_id (pseudonymous), item_id, route, category, status, elapsed_hours, platform, experiment_arm. Never send raw certificates, customer names, serials, recordings or PII to general analytics.
Guardrails: false-positive rate, dispute rate, revocation latency, consent compliance, reviewer QA, net unit contribution. Conversion lift requires randomized or carefully matched comparisons, not assumptions from infographic.

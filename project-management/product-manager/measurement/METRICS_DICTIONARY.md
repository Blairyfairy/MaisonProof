# Metrics and instrumentation specification
**North Star candidate:** valid public proof-record views by distinct buyers (with anti-bot safeguards).

**Funnel:** merchant contacted → qualified → onboarded → first item submitted → first completed review → first badge published → first buyer record view → repeat submissions. Measure each stage and elapsed time.

**Quality:** independently sampled false approval/false rejection; inconclusive rate; duplicate detection; revocation latency; review overturn rate; reviewer disagreement; complaint rate. **Operational:** p50/p95 turnaround, reviewer utilization, evidence request cycles, shipping exceptions, uptime, p95 record lookup. **Commercial:** net revenue per case, contribution margin, CAC, CAC payback, churn, merchant LTV, cohort retention, refunds, chargebacks.

**Event taxonomy:** `merchant_registered`, `item_created`, `route_selected`, `evidence_uploaded`, `shipment_received`, `review_requested`, `decision_recorded`, `record_issued`, `record_revoked`, `badge_rendered`, `record_opened`, `invoice_paid`, `dispute_opened`. Include tenant-safe IDs, event timestamp, method, status, channel and schema version; never log raw private evidence.

**Dashboard cadence:** daily operational quality; weekly funnel; monthly finance/cohort; quarterly strategic outcomes. All metric definitions require a named owner and SQL validation before external reporting.

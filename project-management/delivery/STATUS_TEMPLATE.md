# Weekly status report template
Week of: [date] · PM: [name] · Overall RAG: [green/amber/red]
**Executive summary:** [one paragraph]
**Completed:** [IDs and evidence]
**Next:** [IDs, owners, dates]
**Metrics:** throughput, cycle time, defects, risks, spend vs budget, critical path variance.
**Decisions required:** [ID / owner / due]
**Top 3 risks:** [risk, trend, mitigation]
**Changes:** [approved scope and impact]
**Links:** board, design, test report, release artifacts.

## Ceremonies
Sprint planning: capacity + commitment; daily: blockers; mid-sprint backlog refinement; demo: acceptance evidence; retrospective: 1–2 owned improvements; steering committee biweekly; trust/security review at every approval milestone.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **STATUS_TEMPLATE-01:** Report delivered code versus unverified requirements separately. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-02:** Include platform smoke test results, AWS stack drift, alarms, AI evaluation, blockers and release decision. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-03:** Named accountable owner and dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-04:** Shopify installation, scopes and webhooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-05:** WooCommerce publish/update/retry flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-06:** Magento observers, queue and admin ACL. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-07:** AWS asynchronous processing and DLQ. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **STATUS_TEMPLATE-08:** Evidence-backed acceptance and rollback. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

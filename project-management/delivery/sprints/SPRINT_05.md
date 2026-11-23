# Sprint 05 — Reviewer console
**Duration:** 2 weeks (estimate; dates TBD). **Goal:** deliver demonstrable, tested progress on reviewer console.
## Committed candidate backlog
- **LP-0501** Queue and assignment: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0502** Evidence comparison: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0503** Second-review flow: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0504** Decision rationale: acceptance demo, test evidence, documentation and owner signoff.

## Plan and ceremonies
Planning: size stories and capacity; daily blockers; mid-sprint refinement; end-sprint demo and retrospective. Record decisions, scope changes and carryover.
## Exit criteria
No critical security/trust regressions; accessibility checks; acceptance criteria met; Product and relevant Trust/Security leads approve; RAID and roadmap updated.
## Dependencies / risks
See `../DEPENDENCIES.md` and `../RAID.md`. Unstaffed reviewer roles and uninsured shipments block any real-world authentication service.

## Expanded multi-platform / AI / AWS scope (proposed, not completed)
**AWS event pipeline.** SQS retries/DLQ, idempotency, audit events, queue reconciliation, PITR restore rehearsal, S3 retention controls; acceptance: fault injection and RPO/RTO evidence.
**Deliverables:** architecture decision, code changes, test fixtures, deployment steps, rollback steps, evidence links and named sign-off owner.
**Status:** Planned; do not mark complete without captured execution evidence.


## AI-assisted authenticity capability — expanded acceptance gates

- Deliverable: Add Shopify installation/OAuth, compliance webhooks, metafield ownership and signed synchronization.
- Evidence required: traceable implementation commit, test output, owner sign-off, and explicit PASS/FAIL.
- Status: **planned; not independently validated**.

## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SPRINT_05-01:** Sprint 05 focus: Shopify app and lifecycle. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-02:** Document exact repository paths and assigned owners for the sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-03:** Include three-platform impact analysis and versioned API change log. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-04:** Provide reproducible positive and negative test results with links to artifacts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-05:** Record blockers, residual risks and the go/no-go handoff to next sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-06:** Sprint objective and explicit scope. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-07:** Cross-platform deliverables and owner. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-08:** AWS resources and API dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-09:** Security, AI and human review controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-10:** Executable test and evidence artifact. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_05-11:** Release decision, risks and next sprint. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

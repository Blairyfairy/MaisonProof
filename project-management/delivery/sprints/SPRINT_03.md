# Sprint 03 — Case engine
**Duration:** 2 weeks (estimate; dates TBD). **Goal:** deliver demonstrable, tested progress on case engine.
## Committed candidate backlog
- **LP-0301** State machine: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0302** Audit event log: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0303** Item identity binding: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0304** Secure evidence storage: acceptance demo, test evidence, documentation and owner signoff.

## Plan and ceremonies
Planning: size stories and capacity; daily blockers; mid-sprint refinement; end-sprint demo and retrospective. Record decisions, scope changes and carryover.
## Exit criteria
No critical security/trust regressions; accessibility checks; acceptance criteria met; Product and relevant Trust/Security leads approve; RAID and roadmap updated.
## Dependencies / risks
See `../DEPENDENCIES.md` and `../RAID.md`. Unstaffed reviewer roles and uninsured shipments block any real-world authentication service.

## Expanded multi-platform / AI / AWS scope (proposed, not completed)
**Shared trust and tenant model.** Tenant onboarding, per-merchant secret isolation, signed requests, webhook replay and idempotency, threat model; acceptance: cross-tenant access tests and key rotation drill.
**Deliverables:** architecture decision, code changes, test fixtures, deployment steps, rollback steps, evidence links and named sign-off owner.
**Status:** Planned; do not mark complete without captured execution evidence.


## AI-assisted authenticity capability — expanded acceptance gates

- Deliverable: Implement optional Bedrock image-quality triage with manual-review fallback; no automatic authenticity claims.
- Evidence required: traceable implementation commit, test output, owner sign-off, and explicit PASS/FAIL.
- Status: **planned; not independently validated**.

## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SPRINT_03-01:** Sprint 03 focus: Reviewer decision authority. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-02:** Document exact repository paths and assigned owners for the sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-03:** Include three-platform impact analysis and versioned API change log. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-04:** Provide reproducible positive and negative test results with links to artifacts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-05:** Record blockers, residual risks and the go/no-go handoff to next sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-06:** Sprint objective and explicit scope. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-07:** Cross-platform deliverables and owner. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-08:** AWS resources and API dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-09:** Security, AI and human review controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-10:** Executable test and evidence artifact. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_03-11:** Release decision, risks and next sprint. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

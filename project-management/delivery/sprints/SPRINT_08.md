# Sprint 08 — WooCommerce launch path
**Duration:** 2 weeks (estimate; dates TBD). **Goal:** deliver demonstrable, tested progress on woocommerce launch path.
## Committed candidate backlog
- **LP-0801** Badge adapter: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0802** Public verification UX: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0803** Fail-closed tests: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0804** Sandbox UAT: acceptance demo, test evidence, documentation and owner signoff.

## Plan and ceremonies
Planning: size stories and capacity; daily blockers; mid-sprint refinement; end-sprint demo and retrospective. Record decisions, scope changes and carryover.
## Exit criteria
No critical security/trust regressions; accessibility checks; acceptance criteria met; Product and relevant Trust/Security leads approve; RAID and roadmap updated.
## Dependencies / risks
See `../DEPENDENCIES.md` and `../RAID.md`. Unstaffed reviewer roles and uninsured shipments block any real-world authentication service.

## Expanded multi-platform / AI / AWS scope (proposed, not completed)
**WooCommerce production hardening.** HPOS compatibility, credential isolation, background job retries, status synchronization and revocation, accessible badge, WordPress multisite tests; acceptance: end-to-end UAT.
**Deliverables:** architecture decision, code changes, test fixtures, deployment steps, rollback steps, evidence links and named sign-off owner.
**Status:** Planned; do not mark complete without captured execution evidence.


## AI-assisted authenticity capability — expanded acceptance gates

- Deliverable: Build blinded authentic/counterfeit dataset with provenance and legal rights.
- Evidence required: traceable implementation commit, test output, owner sign-off, and explicit PASS/FAIL.
- Status: **planned; not independently validated**.

## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SPRINT_08-01:** Sprint 08 focus: AWS resilience and observability. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-02:** Document exact repository paths and assigned owners for the sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-03:** Include three-platform impact analysis and versioned API change log. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-04:** Provide reproducible positive and negative test results with links to artifacts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-05:** Record blockers, residual risks and the go/no-go handoff to next sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-06:** Sprint objective and explicit scope. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-07:** Cross-platform deliverables and owner. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-08:** AWS resources and API dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-09:** Security, AI and human review controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-10:** Executable test and evidence artifact. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_08-11:** Release decision, risks and next sprint. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

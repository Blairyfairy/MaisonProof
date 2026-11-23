# Sprint 09 — Shopify integration
**Duration:** 2 weeks (estimate; dates TBD). **Goal:** deliver demonstrable, tested progress on shopify integration.
## Committed candidate backlog
- **LP-0901** Theme/app adapter: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0902** Platform auth: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0903** App policy review: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0904** Sandbox UAT: acceptance demo, test evidence, documentation and owner signoff.

## Plan and ceremonies
Planning: size stories and capacity; daily blockers; mid-sprint refinement; end-sprint demo and retrospective. Record decisions, scope changes and carryover.
## Exit criteria
No critical security/trust regressions; accessibility checks; acceptance criteria met; Product and relevant Trust/Security leads approve; RAID and roadmap updated.
## Dependencies / risks
See `../DEPENDENCIES.md` and `../RAID.md`. Unstaffed reviewer roles and uninsured shipments block any real-world authentication service.

## Expanded multi-platform / AI / AWS scope (proposed, not completed)
**Shopify integration.** OAuth installation and uninstall lifecycle, webhook HMAC, webhook registration, Admin GraphQL metafield synchronization, theme app extension, privacy webhooks, app review; acceptance: verified/revoked badge sync and tenant isolation.
**Deliverables:** architecture decision, code changes, test fixtures, deployment steps, rollback steps, evidence links and named sign-off owner.
**Status:** Planned; do not mark complete without captured execution evidence.


## AI-assisted authenticity capability — expanded acceptance gates

- Deliverable: Evaluate false acceptance rate, false rejection rate, calibration, subgroup performance and drift.
- Evidence required: traceable implementation commit, test output, owner sign-off, and explicit PASS/FAIL.
- Status: **planned; not independently validated**.

## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SPRINT_09-01:** Sprint 09 focus: AI evidence triage. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-02:** Document exact repository paths and assigned owners for the sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-03:** Include three-platform impact analysis and versioned API change log. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-04:** Provide reproducible positive and negative test results with links to artifacts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-05:** Record blockers, residual risks and the go/no-go handoff to next sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-06:** Sprint objective and explicit scope. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-07:** Cross-platform deliverables and owner. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-08:** AWS resources and API dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-09:** Security, AI and human review controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-10:** Executable test and evidence artifact. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_09-11:** Release decision, risks and next sprint. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

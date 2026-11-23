# Sprint 01 — Research & wireframes
**Duration:** 2 weeks (estimate; dates TBD). **Goal:** deliver demonstrable, tested progress on research & wireframes.
## Committed candidate backlog
- **LP-0101** Merchant interviews: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0102** Buyer trust research: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0103** Journey maps: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0104** Usability baseline: acceptance demo, test evidence, documentation and owner signoff.

## Plan and ceremonies
Planning: size stories and capacity; daily blockers; mid-sprint refinement; end-sprint demo and retrospective. Record decisions, scope changes and carryover.
## Exit criteria
No critical security/trust regressions; accessibility checks; acceptance criteria met; Product and relevant Trust/Security leads approve; RAID and roadmap updated.
## Dependencies / risks
See `../DEPENDENCIES.md` and `../RAID.md`. Unstaffed reviewer roles and uninsured shipments block any real-world authentication service.


## AI-assisted authenticity capability — expanded acceptance gates

- Deliverable: Implement evidence intake contracts, product provenance metadata, privacy consent and image retention.
- Evidence required: traceable implementation commit, test output, owner sign-off, and explicit PASS/FAIL.
- Status: **planned; not independently validated**.

## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SPRINT_01-01:** Sprint 01 focus: Core API and tenancy. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-02:** Document exact repository paths and assigned owners for the sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-03:** Include three-platform impact analysis and versioned API change log. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-04:** Provide reproducible positive and negative test results with links to artifacts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-05:** Record blockers, residual risks and the go/no-go handoff to next sprint. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-06:** Sprint objective and explicit scope. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-07:** Cross-platform deliverables and owner. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-08:** AWS resources and API dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-09:** Security, AI and human review controls. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-10:** Executable test and evidence artifact. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINT_01-11:** Release decision, risks and next sprint. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

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

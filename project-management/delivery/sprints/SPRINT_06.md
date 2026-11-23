# Sprint 06 — Shipment workflow
**Duration:** 2 weeks (estimate; dates TBD). **Goal:** deliver demonstrable, tested progress on shipment workflow.
## Committed candidate backlog
- **LP-0601** Carrier/insurance evaluation: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0602** Shipment quote UI: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0603** Tracking/custody: acceptance demo, test evidence, documentation and owner signoff.
- **LP-0604** Loss/return exception: acceptance demo, test evidence, documentation and owner signoff.

## Plan and ceremonies
Planning: size stories and capacity; daily blockers; mid-sprint refinement; end-sprint demo and retrospective. Record decisions, scope changes and carryover.
## Exit criteria
No critical security/trust regressions; accessibility checks; acceptance criteria met; Product and relevant Trust/Security leads approve; RAID and roadmap updated.
## Dependencies / risks
See `../DEPENDENCIES.md` and `../RAID.md`. Unstaffed reviewer roles and uninsured shipments block any real-world authentication service.

## Expanded multi-platform / AI / AWS scope (proposed, not completed)
**Evidence and AI triage.** Presigned uploads, malware checks, EXIF/privacy policy, image quality gate, human escalation, model/version logging, evaluation dataset and calibration; acceptance: no automated verified decision without approved controls.
**Deliverables:** architecture decision, code changes, test fixtures, deployment steps, rollback steps, evidence links and named sign-off owner.
**Status:** Planned; do not mark complete without captured execution evidence.


## AI-assisted authenticity capability — expanded acceptance gates

- Deliverable: Add WooCommerce background retry queue, permission checks, product variants and status synchronization.
- Evidence required: traceable implementation commit, test output, owner sign-off, and explicit PASS/FAIL.
- Status: **planned; not independently validated**.

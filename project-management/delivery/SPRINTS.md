# Sprint execution plan
Two-week cadence is illustrative. Every sprint includes refinement, daily coordination, demo, retro, security review and updated RAID. Exit criteria: acceptance criteria met, tests passed, documentation updated, product-owner approval.

| Sprint | Theme | Deliverable | Gate |
|---|---|---|---|
| 0 | Discovery / kickoff | charter, stakeholders, baseline, brand audit | sponsor approval |
| 1 | Research / UX | interviews, journeys, Figma-ready wireframes | usability review |
| 2 | Trust policy / identity | authentication SOP, merchant roles | legal/trust approval |
| 3 | Case engine | states, audit, secure intake | threat model |
| 4 | Remote evidence | uploads, consent, media, chat | privacy QA |
| 5 | Reviewer console | evidence queue, requests, decision draft | reviewer dry run |
| 6 | Shipment workflow | quotes, insurance disclosures, custody | partner sandbox |
| 7 | Certificates | signer, expiry, dispute/revocation | adversarial tests |
| 8 | WooCommerce + public lookup | live badge, fail-closed status | UAT signoff |
| 9 | Shopify | theme/app adapter, app compliance | sandbox pass |
| 10 | Magento + billing | module, subscriptions, per-case fees | integration pass |
| 11 | Pilot | limited merchants, support, telemetry | quality thresholds |
| 12 | Hardening + launch decision | DR, accessibility, pen test, runbooks | go/no-go |

Detailed per-sprint files are in `sprints/` and backlog is `backlog.csv`.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **SPRINTS-01:** Map Sprints 00–12 to security foundation, three adapters, evidence pipeline, reviewer flows, AI evaluation and release. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-02:** Every sprint closes only with code, tests, logs/screenshots and named acceptance owner. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-03:** Named accountable owner and dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-04:** Shopify installation, scopes and webhooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-05:** WooCommerce publish/update/retry flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-06:** Magento observers, queue and admin ACL. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-07:** AWS asynchronous processing and DLQ. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **SPRINTS-08:** Evidence-backed acceptance and rollback. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

# Delivery roadmap (planning baseline)
| Phase | Sprints | Outcome | Exit gate |
|---|---|---|---|
| Discover & govern | 0–1 | evidence, requirements, risks, brand system | approved PRD and feasibility |
| Trust foundation | 2–3 | identities, cases, audit, review policy | threat-model sign-off |
| Two review routes | 4–6 | remote portal and shipment lifecycle | end-to-end sandbox walkthrough |
| Certificate + WooCommerce | 7–8 | signed status, revocation, public page, plugin | no false-positive badge in tests |
| Commerce expansion | 9–10 | Shopify and Magento adapters, billing | platform compliance checks |
| Pilot & launch readiness | 11–12 | pilot, hardening, runbooks, legal sign-off | go/no-go approval |

**Critical path:** qualified reviewers → enforceable policy → secure evidence storage → decision signing → revocation-aware verification → platform badges → controlled pilot. Dates are placeholders; avoid commitments until staffing and vendor contracts are known.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **ROADMAP-01:** Stage 0 threat model, source audit, requirements and tenancy. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-02:** Stage 1 production-safe ingestion, credentials, idempotency, evidence quarantine. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-03:** Stage 2 Shopify, WooCommerce, Magento end-to-end status synchronization. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-04:** Stage 3 human review, signed certificates, disputes and revocation. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-05:** Stage 4 labeled data, independent AI validation and controlled rollout. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-06:** Product boundary and target merchant personas. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-07:** Functional behavior and exception paths. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-08:** Cross-platform event and status contracts. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-09:** Evidence, AI triage and independent review. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-10:** Nonfunctional SLOs, privacy and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **ROADMAP-11:** Delivery milestones, owners and exit gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

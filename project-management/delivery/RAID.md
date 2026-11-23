# Risks, assumptions, issues, dependencies
| ID | Type | Severity | Item | Mitigation / trigger | Owner |
|---|---|---|---|---|---|
| R1 | Risk | Critical | False authenticated badge | fail-closed signed decision + adversarial tests | Security |
| R2 | Risk | Critical | Unqualified reviewers / unsupported claims | recruit experts, publish review scope | Trust |
| R3 | Risk | High | Loss/damage in transit | carrier SLAs, custody logs, explicit insurance | Ops/Legal |
| R4 | Risk | High | Sensitive media leakage | encryption, access controls, retention | Security |
| R5 | Risk | High | Trademark/brand endorsement confusion | legal review, no implied partnerships | Legal |
| R6 | Risk | High | Unit economics negative | cost pilot, category pricing, no subsidized unlimited reviews | Finance |
| R7 | Risk | Medium | Platform marketplace policy changes | adapter abstraction and review | Engineering |
| A1 | Assumption | High | Merchants will pay subscription + per review | 20 discovery interviews, paid pilot | Product |
| D1 | Dependency | Critical | Real insurance terms and carrier integration | signed contracts before claims | Ops |
| D2 | Dependency | Critical | Controlled verification domain | secure ownership and DNS | Engineering |
| I1 | Issue | High | Prototype lacks production auth service | build before any real seal issuance | Engineering |


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **RAID-01:** Track spoofed webhooks, stale badges, unbounded uploads, false authentication claims and tenant leakage. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-02:** Record likelihood, impact, mitigation, trigger, owner, contingency and date for every item. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-03:** Named accountable owner and dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-04:** Shopify installation, scopes and webhooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-05:** WooCommerce publish/update/retry flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-06:** Magento observers, queue and admin ACL. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-07:** AWS asynchronous processing and DLQ. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **RAID-08:** Evidence-backed acceptance and rollback. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

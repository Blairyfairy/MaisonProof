# backlog current requirements


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **BACKLOG-01:** Add item-level owner, priority, dependency, status, evidence link and acceptance test. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-02:** Separate implemented foundation from untested integration and future ML development. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-03:** Named accountable owner and dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-04:** Shopify installation, scopes and webhooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-05:** WooCommerce publish/update/retry flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-06:** Magento observers, queue and admin ACL. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-07:** AWS asynchronous processing and DLQ. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **BACKLOG-08:** Evidence-backed acceptance and rollback. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

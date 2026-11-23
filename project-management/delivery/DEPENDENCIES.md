# Dependency register
- Domain and legal entity → trademark counsel, DNS, TLS, signed verification origin.
- Expert reviewer hiring and QA standards → review decisions and credible certificate issuance.
- Storage/security baseline → secure evidence upload, video and chat.
- Insurance partner terms → shipping quotes and insured checkout; never promise coverage before contract.
- Certificate signer and revocation registry → any authenticated storefront badge.
- Platform app approvals and sandbox stores → launch distribution.
- Merchant pilot contracts and consent → research and real-world measurement.
Each dependency needs owner, target date, proof artifact and fallback before sprint commitment.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **DEPENDENCIES-01:** Map storefront APIs and API versions to auth/webhook capabilities. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-02:** Track AWS region, Bedrock model access, CloudFormation artifacts, domains, DNS and certificates. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-03:** Block verification launch on independent review policy, credential isolation and certificate trust chain. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-04:** Named accountable owner and dependency. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-05:** Shopify installation, scopes and webhooks. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-06:** WooCommerce publish/update/retry flows. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-07:** Magento observers, queue and admin ACL. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-08:** AWS asynchronous processing and DLQ. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DEPENDENCIES-09:** Evidence-backed acceptance and rollback. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

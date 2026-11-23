# uat_cases current requirements


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **UAT_CASES-01:** Create scenarios for each platform: publish, update, unpublish, duplicate, invalid signature, rate limit, pending and revoked. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-02:** Include evidence upload failure, reviewer override, stale badge, certificate lookup and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-03:** Unit, contract and negative-path testing. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-04:** Three-platform integration test fixtures. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-05:** Security, tenant isolation and webhook replay. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-06:** Image abuse, malware and upload size limits. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-07:** AI evaluation and human override. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **UAT_CASES-08:** Performance, accessibility and release gates. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

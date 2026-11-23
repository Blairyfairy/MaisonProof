# tokens current requirements


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **TOKENS-01:** Keep token source aligned to actual homepage CSS and SVG colors. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-02:** Map tokens to CSS custom properties, Liquid styles, WordPress and Magento storefront styles. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-03:** MaisonProof logo, typography and color tokens. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-04:** Platform admin controls and error states. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-05:** Public badge status semantics and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-06:** Responsive layouts and secure certificate display. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-07:** Design-to-code component inventory. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **TOKENS-08:** Screenshot parity and QA handoff. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

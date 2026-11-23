# MaisonProof visual system — proposal
Reference the **two refreshed blue-toned reference images** in root `assets/`; this handoff extends their restrained luxury-tech identity.
Logo: fine-line LP monogram within thin shield; wordmark with elegant serif and generous tracking. Do not imply trademark registration until confirmed.
**Typography pair:** Cormorant Garamond (display) + Inter (interface); use licensed/openly available font packages at implementation, not bundled font files. Fallback Georgia + Arial.
**Swatches:** midnight `#080f20`, deep navy `#101d36`, cool ivory `#f4f8ff`, champagne `#e8c77f`, verification ice-blue `#348dce`, blue `#288fc4`, ink `#14233d`, muted `#71839d`. Contrast-test all combinations.
**Rules:** blue verified status means only current authenticated status, not 'submitted'; other states use text labels and neutral/amber/error styling. 8px spacing grid, 16px cards, minimum 44px touch targets, visible focus ring, responsive at 375/768/1440 widths, no text embedded in production UI images.
**Components:** LP crest; store product card with bottom-right badge; tooltip 'View MaisonProof Verification'; two route cards; secure evidence upload; video consent dialog; reviewer timeline; certificate with status, method, scope, timestamp and revocation; merchant billing panel.
**Image policy:** mockup products are illustrative, no implied brand partnership; product photography requires usage rights. Do not use the marketing PNGs as final application screenshots.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **DESIGN_SYSTEM-01:** Match homepage brand asset and tokens on Shopify, WooCommerce and Magento. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-02:** Define semantic badge states: pending, in-review, verified, inconclusive, rejected, revoked, expired. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-03:** Provide contrast, keyboard focus, reduced motion and responsive admin components. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-04:** MaisonProof logo, typography and color tokens. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-05:** Platform admin controls and error states. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-06:** Public badge status semantics and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-07:** Responsive layouts and secure certificate display. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-08:** Design-to-code component inventory. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **DESIGN_SYSTEM-09:** Screenshot parity and QA handoff. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

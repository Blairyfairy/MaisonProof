# Figma-ready design handoff
**Provided:** editable SVG wireframes in `wireframes/`, JSON design tokens, component descriptions and screen flow. Figma can import SVG by drag/drop; recreate components with Auto Layout, variants and variables for production. **Not provided:** a native `.fig` file or an actual shared Figma project (requires a connected Figma account and live collaboration).
Suggested Figma pages: 00 Brand & tokens; 01 Components; 02 Merchant onboarding; 03 Shipment route; 04 Remote route; 05 Reviewer console; 06 Storefront & verification; 07 Admin/operations; 08 Prototype; 09 Accessibility/annotations.
Variants: badge (authenticated, pending-neutral, revoked-hidden); button (default, hover, focus, disabled); case state; upload (empty, scanning, rejected, complete); route card (selected/unselected); device (mobile/desktop).
Prototype connections: storefront → public record; merchant dashboard → route choice → shipment/remote → evidence requests → pending → approved; reviewer → review → decision; revoked → badge removed.
Export: SVG for icons, PNG/WebP for photography, semantic CSS variables for tokens. Include screen-specific acceptance notes and accessible text alternatives.


## Current scenario implementation register — 2026-11-23

Status: Requirements and acceptance gates; not evidence of production completion.

- [ ] **FIGMA_HANDOFF-01:** Provide screen inventory, responsive breakpoints, error/empty/loading states and asset references. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-02:** Link each design to platform component, API contract and screenshot QA evidence. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-03:** MaisonProof logo, typography and color tokens. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-04:** Platform admin controls and error states. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-05:** Public badge status semantics and accessibility. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-06:** Responsive layouts and secure certificate display. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-07:** Design-to-code component inventory. Evidence: code location, automated test, staging trace, owner approval.
- [ ] **FIGMA_HANDOFF-08:** Screenshot parity and QA handoff. Evidence: code location, automated test, staging trace, owner approval.

### Cross-platform release constraints

- Merchant-side apps cannot grant verified status; final decisions remain reviewer-authorized.
- AWS Bedrock image analysis is advisory and is not a validated counterfeit-authenticity classifier.
- Shopify OAuth/compliance webhooks, WooCommerce/Magento retries, tenant isolation, certificate signing, revocation and real-install tests remain release gates unless separately evidenced.
- All platform badges must resolve status against a server-authoritative record and handle pending, rejected, revoked and expired states safely.

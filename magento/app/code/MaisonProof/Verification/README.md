# MaisonProof Verification — Magento 2 / Adobe Commerce

Development module for Magento 2.4.x. Displays a MaisonProof badge on verified product images in standard Magento catalog product lists and links it to a public verification page. Includes an ACL-protected admin record editor and a minimal public REST lookup.

## Install
1. Copy `MaisonProof/Verification/` into `<magento-root>/app/code/MaisonProof/Verification/` (the repository upload archive stores it under `maisonproof/magento/app/code/`).
2. From the Magento root: `php bin/magento module:enable MaisonProof_Verification`.
3. Run `php bin/magento setup:upgrade` and `php bin/magento cache:flush`.
4. In production mode, run `php bin/magento setup:di:compile` and `php bin/magento setup:static-content:deploy -f` as part of your deployment workflow.
5. Grant the **MaisonProof Verification Records** ACL resource to appropriate administrator roles. Open **Catalog > MaisonProof Records**.
6. Create a pending record for a real product ID. Only mark **verified** after independent authentication. Check a product listing and the public verification URL.

## Features
- Public opaque random 128-bit record identifiers, no sequential record lookup.
- Statuses: pending, verified, rejected, revoked; expired calculated when the expiry date passes.
- Badge appears only for verified, unexpired records. Revoked and expired badges disappear.
- Admin access restricted by Magento ACL and standard admin form key.
- Public URL: `/maisonproof/verify/index/id/<32-character-id>/` (URL formatting may vary).
- REST GET: `/rest/V1/maisonproof/record/<32-character-id>` returns only public status, product ID, timestamp and expiry. Internal notes and reviewer never exposed.
- Default CSS and accessible badge link; no alteration of original product photos.

## Important limits
- **Not an authentication engine.** No AI authenticity determination, independent reviewer network, evidence intake, or manufacturer affiliation.
- Requires Magento / Adobe Commerce PHP runtime; **GitHub Pages cannot execute the module**.
- Frontend badge uses plugins on `AbstractProduct::getImage` and `Image::toHtml`; custom themes, headless storefronts, Hyvä, and image pipelines may need adapters.
- Public record lookup is deliberately minimal; consider rate limiting, audit trails, reviewer role separation, admin approval workflow, security monitoring, caching invalidation and privacy review before production.
- The record editor is an MVP; production needs a proper Magento UI component grid, validation, moderation/audit log, and stronger authorization boundaries. No evidence uploads are included.
- Not tested in a running Magento installation. Run integration/security tests on a staging store before deployment.

## Test checklist
- Install and upgrade schema on a clean Magento 2.4.x staging site.
- Verify pending record shows no badge; verified shows badge; revoked/expired hide badge.
- Verify link resolves and returns no private reviewer/notes fields.
- Check product listings, related products, search results, and responsive views.
- Verify non-admin users cannot access admin record management.
- Verify admin CSRF/form key and input handling.
- Check theme-specific product-image rendering and cache behavior.

## MaisonProof branded status artwork
The supplied full logo, white logo and VERIFIED / NOT VERIFIED artwork are bundled locally. Standalone M icons are unchanged. VERIFIED is reserved for the existing approved-record check; other states display NOT VERIFIED. View Record links require an available record identifier; without one the artwork is informational. The badge is not a manufacturer warranty. Existing platform deployment and central API prerequisites still apply.

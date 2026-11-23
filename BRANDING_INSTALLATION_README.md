# MaisonProof — exact homepage brand correction

This is a replacement for the previous three-platform branding package. The **wordmark is now the exact `assets/maisonproof-logo.svg` referenced by the supplied homepage `index.html`**, copied byte-for-byte. It has NOT been redrawn, recolored, or re-typeset.

The **M mark** is cropped from the raster artwork embedded in that exact homepage SVG, with the original gold serif letterform preserved. The M-only SVG contains the cropped original image, not an approximate vector path. Small-size favicon/PNG exports use the same original letterform.

The effective homepage palette uses `#f8fbff` for its light background, `#152d4c` navy, `#b78a3e` gold, `#2476b7` blue, `#cbdced` border, and `#58708e` muted text. Georgia headings and Inter/Arial interface fonts are retained.

## Installation
- **WordPress / WooCommerce:** Upload the separately packaged WooCommerce ZIP or copy `wordpress/maisonproof-woocommerce` into `wp-content/plugins`. Activate and open MaisonProof Records → Brand Dashboard.
- **Magento / Adobe Commerce:** Copy `magento/app/code/MaisonProof/Verification` into your installation. Run Magento module upgrade, DI compilation and static asset deployment for your release process. The MaisonProof admin records page and public record page use the exact homepage wordmark.
- **Shopify:** Deploy `shopify/extensions/maisonproof-badge` through an existing Shopify app using Shopify CLI. The storefront theme block displays the exact homepage wordmark, or the M-only asset in compact mode. The Shopify embedded admin `shopify/admin-ui/brand-dashboard.html` is a static design reference, not a production OAuth-enabled embedded app.

Global platform favicon overrides are deliberately not applied, because they would change unrelated WordPress/Magento/Shopify admin screens. The MaisonProof M favicon assets are supplied for MaisonProof-controlled pages.

The central authentication logic is not changed. These are brand asset and styling corrections, not a claim of live app installation, verified authenticity, or end-to-end testing.

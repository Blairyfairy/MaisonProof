# MaisonProof plugin + central API patch

Copy only these paths into the existing repository, preserving directory structure. Existing homepage and documentation files are not changed. Existing storefront plugin functionality is retained; the central submission path is **opt-in**.

## Branding
Both plugin bundles contain the exact SVG from the repository `assets/maisonproof-logo.svg`. The existing WooCommerce stylesheet and Magento CSS are retained. Logos are supplied as assets; not all theme-specific layouts automatically render them. Review frontend placement in the installed theme.

## WordPress / WooCommerce
Upload `wordpress/maisonproof-woocommerce` as a plugin folder, activate, then open **Settings → MaisonProof Central API**. Enter deployed API URL, store ID, signing secret, and enable. Product updates submit published items as pending. The legacy plugin's local record functionality remains separate; do not equate a local badge with central verification. Production must unify badge status with central API.

## Magento 2.4
Copy `magento/app/code/MaisonProof/Verification` into Magento app/code, run `bin/magento setup:upgrade`, compile and deploy static assets in production, and flush caches. Open **Stores → Configuration → General → MaisonProof → Central Submission API**. Product saves in admin submit pending items. This prototype observer makes a synchronous outbound request; move to a queue/outbox with retries before high-volume production. Magento's legacy local verification records are not yet synchronized to the central service.

## Integration caveats
- These are not live-tested against deployed WordPress, Magento, or AWS. No claims of marketplace approval, production readiness, or verified authentication.
- Product submissions create pending records; no automatic approval. Admin reviewer endpoint is a bootstrap demonstration only.
- Full competitor parity requires merchant onboarding, per-tenant secrets, webhooks, status reconciliation, evidence upload, reviewer queue, risk scoring, SLA metrics, QR/NFC identifiers, anti-cloning controls, accessibility testing, localization, PCI/privacy review, incident response, and operational load testing.
- The existing `wordpress/maisonproof.php` and `magento/maisonproof/` packaging were not overwritten; this patch targets the active module paths shown in the repository.

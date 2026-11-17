# Delivery roadmap

**Included now:** API product registry, evidence hash/reference intake, reviewer-only decisions, audit rows, public status, WooCommerce product sync and badges, Magento 2 storefront badges, smoke test, setup docs.

**Next (production blockers):** tenant-scoped credentials and RBAC, reviewer web console, real evidence storage, expert/brand attestation checks, unit-level serial passports, revocation, signature verification, async queues, integration tests in actual WooCommerce/Magento instances, WordPress.org/Adobe Marketplace compliance review, security audit.

**Then:** Stripe subscriptions and usage metering, Shopify adapter, supplier invitation portal, signed QR credentials, distributor registry, bulk import, evidence expiry reminders, analytics, SSO, webhooks, compliance exports.

**Business integrity:** Supplier verified != item authenticated. The platform must show evidence provenance and review basis, not create false certainty.

- Add Magento product syncing and Drupal Commerce product SKU integration.
- Validate Django integration and each CMS version in CI.
- Add certificate expiry/revocation and public verification pages.

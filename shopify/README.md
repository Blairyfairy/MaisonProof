# Shopify integration — implementation foundation

The Shopify CLI project requires a Partner/Dev Dashboard app, HTTPS application host, OAuth installation/session persistence, mandatory privacy webhooks, and deployment of the theme extension. Replace placeholders in shopify.app.toml; validate current Shopify API version and app review requirements before distribution.

## Flow
1. Merchant installs app using Shopify OAuth. Store shop domain and access token securely, never in theme assets.
2. Register `products/create` and `products/update` webhook subscriptions. Shopify signs the raw body with `X-Shopify-Hmac-Sha256` using the app client secret.
3. Central webhook handler verifies signature and the allowlisted shop, then creates a `pending` record with idempotency using webhook ID.
4. Review is performed centrally; publishing a product does **not** authenticate it.
5. For verified status, a separate backend synchronization worker (not implemented here) must write the `maisonproof.status` product metafield using Shopify Admin GraphQL with the correct permissions and installation context. Until then the badge displays 'Verification not available'.
6. Reconcile status on revocation, uninstall and webhook delivery failures. Validate data erasure and app privacy requirements.

**Not production-ready:** OAuth app host, Admin API metafield sync, webhook registration lifecycle, mandatory compliance webhooks, uninstall handling, and end-to-end testing remain required. The theme block is functional as a display-only status component once its metafield exists.

## MaisonProof branded status artwork
The supplied full logo, white logo and VERIFIED / NOT VERIFIED artwork are bundled locally. Standalone M icons are unchanged. VERIFIED is reserved for the existing approved-record check; other states display NOT VERIFIED. View Record links require an available record identifier; without one the artwork is informational. The badge is not a manufacturer warranty. Existing platform deployment and central API prerequisites still apply.

# MaisonProof Luxury Verification for WooCommerce

A working WordPress/WooCommerce plugin starter with **controlled status records, image-overlay badges, public lookup, product assignment, REST lookup, merchant evidence submission, and an admin dashboard**. Its UI follows MaisonProof's navy/champagne branding.

## Installation

1. Upload the **`maisonproof-woocommerce`** folder to your existing MaisonProof GitHub repository at `wordpress/maisonproof-woocommerce/`. GitHub Pages cannot execute PHP; the plugin must also be installed on a WordPress server.
2. Zip the `maisonproof-woocommerce` folder itself, then install using **WordPress Admin → Plugins → Add New → Upload Plugin**; activate WooCommerce first.
3. Create a WordPress page with slug `maisonproof-verification` and shortcode `[maisonproof_verify]`.
4. Under **MaisonProof Records → Add New**, publish a record with a unique record ID, the numeric WooCommerce product ID, brand/model, review date and status. **Only an administrator can set verified.**
5. On that WooCommerce product's **Product data → General**, enter the same MaisonProof record ID and update. An approved, unexpired record displays an image-area seal on the product and catalog pages.
6. For merchant submissions, create a page containing `[maisonproof_submit]`. Merchants need WordPress permission to edit the relevant product. Review submissions in WordPress admin.
7. Badge positioning is configurable under **MaisonProof Records → Settings**.

## Shortcodes and API

- `[maisonproof_verify]` — public lookup form, or `[maisonproof_verify id="MP-EXAMPLE-01"]`
- `[maisonproof_badge product_id="123"]` — seal for a verified product
- `[maisonproof_submit]` — merchant evidence intake
- `GET /wp-json/maisonproof/v1/records/MP-EXAMPLE-01` — sanitized public status JSON

## Security and production limitations

- **Do not treat a badge as proof of authenticity without independent professional review.** The plugin does not authenticate luxury items using AI or expert analysis; it manages review decisions made elsewhere.
- **Important:** standard WordPress Media Library uploads often have publicly guessable URLs. The merchant evidence uploader therefore **must not be used for sensitive customer documents or serial numbers in production** until private file storage, authenticated download authorization, retention policies, malware scanning and consent controls are added. The current upload flow is suitable for non-sensitive test images only.
- This version uses local administrator-controlled records. It is **not connected to a central MaisonProof authority**; if deployed across multiple stores, each installation maintains its own decisions. For a trust-network product, replace local issuance with signed decisions from a centralized verification API.
- Public lookup includes only record ID, status, brand/model, decision/expiry dates. Private reviewer notes and serials are excluded.
- Badge injection is implemented with standard WooCommerce hooks. Some block themes or third-party gallery layouts may need an integration adapter.
- Only administrators should have permission to create or approve records; do not grant that capability to untrusted merchants.
- No background certificate signing, fraud detection, AI authentication, payments, or off-site authentication fulfillment is claimed.

## Acceptance checklist

- [ ] Unverified product: no badge
- [ ] Pending record: no badge
- [ ] Verified record with matching product: badge on shop and single-product views
- [ ] Mismatched record/product IDs: no badge
- [ ] Revoked/expired record: badge disappears
- [ ] Public REST endpoint excludes private fields
- [ ] Merchant cannot change verification status
- [ ] Unauthorized user cannot upload evidence for another merchant's product
- [ ] Check mobile product gallery, WooCommerce Blocks and your actual theme

## Files

`maisonproof-woocommerce.php` — plugin backend, admin controls, WooCommerce hooks, REST and shortcodes

`assets/maisonproof.css` — storefront styles

`assets/maisonproof-logo.svg` — original MaisonProof brand logo asset from the existing repo (not modified)

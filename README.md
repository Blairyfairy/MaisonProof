# MAISONPROOF

**Confidence in every detail.**  
*The authentication layer for luxury commerce.*

MaisonProof is a multi-platform provenance and authentication software project for luxury retailers. Its aim is to help merchants document product origins, request appropriate independent reviews, and present a clear, restrained verification status to shoppers.

**[Explore the interactive showroom](index.html)** · **[GitHub Pages setup](docs/GITHUB_PAGES.md)** · **[Security](docs/SECURITY.md)** · **[Roadmap](docs/ROADMAP.md)**

## Explore the showroom

The root-level `index.html` is a responsive, black-and-white product showcase ready for GitHub Pages. It demonstrates a luxury product page, four verification states, a sample certificate, a merchant dashboard, and interactive previews for WooCommerce, Magento 2, Drupal, and Django. It requires no build step. **All showcase records and metrics are fictional.**

## Brand principle

MaisonProof uses restrained typography, monochrome components, simple status language, and minimal badges that respect a merchant's visual identity. A badge must not imply independent authentication when evidence has not been reviewed. Registration and uploaded invoices alone are not proof of authenticity.

## Source tree

| Directory | Purpose |
| --- | --- |
| `service/` | Shared FastAPI prototype and tests |
| `wordpress/maisonproof-verify/` | WordPress / WooCommerce plugin |
| `magento2/Maisonproof/Verify/` | Magento 2 module |
| `drupal/maisonproof_verify/` | Drupal module and block |
| `django/maisonproof/` | Django app and template tag |
| `assets/` | Shared plugin styling |
| `site/` | GitHub Pages CSS, JS, and icon |
| `docs/` | Security, business model, roadmap, and deployment |

## Implementation status

This is an **MVP / demonstration**, not a production authentication authority. The WordPress integration has product synchronization and display logic; Magento 2, Drupal, and Django have narrower display-oriented integrations. The backend is a prototype. Independent authentication partnerships, multi-tenant access controls, secured evidence storage, billing, certificate revocation controls, and full production integration testing remain necessary.

## Quick start

**Showroom:** Open `index.html` locally or enable GitHub Pages as described in [`docs/GITHUB_PAGES.md`](docs/GITHUB_PAGES.md).

**Backend:** Review `service/requirements.txt` and `service/app.py`; install dependencies in a virtual environment and start the ASGI app with `uvicorn app:app --reload` from the `service` directory. Never expose a development configuration publicly.

**Commerce integrations:** See the integration directories and their existing instructions. Configure an independently deployed MaisonProof API endpoint; GitHub Pages cannot run the service or the plugins.

## Trust and disclosure

MaisonProof does not itself establish that any real-world product is authentic. The public demonstration contains no live verification. Production authentication claims must be supported by qualified reviewers, documented evidence, and verifiable records. Avoid brand endorsements, partnerships, and certification claims unless independently substantiated.

## Commercial direction

Proposed revenue streams include subscriptions for merchants, usage-based verification reviews, and enterprise integrations. Pricing and forecast examples are planning assumptions, not promises. See [`docs/BUSINESS.md`](docs/BUSINESS.md).

## License and name

See [`LICENSE`](LICENSE) for source license. The MaisonProof name is provisional and requires trademark and domain clearance before commercial launch.

---

### Original project notes and implementation details

# MAISONPROOF

**Proof of origin. Confidence in every detail.**

A quiet, black-and-white trust layer for luxury commerce. MaisonProof helps merchants connect product listings to a separately maintained provenance record and, where supported by evidence and independent review, display an understated authentication mark.

> **MAISONPROOF · Independently authenticated · View record**

The badge is deliberately restrained: system typography, white background, near-black border, no gold, gradients, intrusive overlays, or inflated claims. Customers can follow **View record** to see the verification status. The mark is displayed **only** for an `authenticated` response; an unavailable service never becomes an implicit approval.

## What MaisonProof does

1. A merchant registers a product with its SKU, brand and supplier.
2. Supporting evidence is recorded by reference and SHA-256 digest.
3. An authorized reviewer evaluates the evidence and records a decision.
4. A supported storefront displays the MaisonProof mark **only after** an authenticated decision.
5. If supplier or brand details change, the product returns to unverified.

**Important:** Merchant-supplied documents and even an attestation reference are not proof of authenticity by themselves. This MVP does not establish an independent authentication network, certify any luxury brand, or warrant that a product is genuine. Do not advertise the mark as brand endorsement.

## Repository

| Folder | Purpose | Current maturity |
|---|---|---|
| `service/` | FastAPI provenance registry and reviewer workflow | Local MVP, not multi-tenant production SaaS |
| `wordpress/maisonproof-verify/` | WooCommerce product sync and badge | Starter integration; requires WooCommerce |
| `magento2/Maisonproof/Verify/` | Magento 2 / Adobe Commerce product-page badge | Read-only storefront integration |
| `drupal/maisonproof_verify/` | Drupal 10/11 configurable badge block | Manual SKU display integration |
| `django/maisonproof/` | Django template tag and CSS | Read-only template integration |
| `assets/` | Shared monochrome design system | Reusable |
| `docs/` | Security, roadmap and business model | Planning documentation |

## Quick start: registry

```bash
cd service
python -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt
export MAISONPROOF_MERCHANT_KEY="$(python -c 'import secrets; print(secrets.token_urlsafe(40))')"
export MAISONPROOF_REVIEWER_KEY="$(python -c 'import secrets; print(secrets.token_urlsafe(40))')"
uvicorn app:app --host 127.0.0.1 --port 8000
```

Use a real HTTPS reverse proxy for any external access. Never commit credentials. API documentation is at `/docs`.

### WordPress / WooCommerce

Copy `wordpress/maisonproof-verify` into `wp-content/plugins/` and activate **MaisonProof Verify**. Under WooCommerce → MaisonProof Verify enter the HTTPS registry URL, store ID and merchant API key. Each product needs a SKU, `pa_brand` attribute and `_maisonproof_supplier_name` metadata for synchronization. Verified products display a mark automatically on their detail pages; `[maisonproof_verify id="123"]` is also available.

### Magento 2 / Adobe Commerce

Copy `magento2/Maisonproof/Verify` into `app/code/Maisonproof/Verify`, then run:

```bash
php bin/magento module:enable Maisonproof_Verify
php bin/magento setup:upgrade
php bin/magento cache:flush
```

Configure **Stores → Configuration → MaisonProof → Verify** with the HTTPS service URL and store ID. This adapter reads statuses; it does **not** automatically register inventory.

### Drupal

See [`drupal/README.md`](drupal/README.md). Configure the service, then place a badge block with the SKU.

### Django

See [`django/README.md`](django/README.md). Install the app, load the template tag and include the stylesheet.

## Brand rules

- **Name:** MaisonProof (displayed as `MAISONPROOF` on the mark)
- **Promise:** Proof of origin. Confidence in every detail.
- **Colors:** `#111111` text and border, `#FFFFFF` background; neutral grays for supporting text
- **Typeface:** platform system sans-serif stack; no external font requests
- **Behavior:** display authentication claims only for authenticated products; never display a positive badge for pending, rejected, missing, or unreachable records
- **Voice:** measured, specific, factual; never claim a brand approved a product unless verified directly

## Tests

```bash
cd service
pip install -r requirements.txt
pytest -q
```

## Before selling or deploying

This is a **developer MVP**, not a certified authentication service. Add per-merchant credentials and tenant isolation, hardened reviewer accounts, independent verifier onboarding, attestation validation, secure evidence storage, revocation and expiry, rate limiting, audit logging, signed public records, billing, observability, privacy controls, and end-to-end integration tests. See `docs/SECURITY.md` and `docs/ROADMAP.md`. The current shared merchant key is unsuitable for hosting unrelated paying stores.

## Business model

Offer free-to-install storefront connectors, paid SaaS tiers based on active SKUs, and separately priced expert reviews. Never charge for a guaranteed positive authentication outcome. Proposed name and mark require trademark and domain clearance before commercial use.

## License

See `LICENSE` (MIT). Commercial hosted verification and review services can be offered separately, subject to the license and any third-party agreements.

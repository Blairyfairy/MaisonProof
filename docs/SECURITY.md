# Security and authentication assurance

## Trust boundary
Merchant-submitted claims are **not** authenticity. The merchant API cannot set verified status. A reviewer API can set it only after an attestation reference is registered; the current MVP does **not** validate the identity, expertise, or independence of the attestor. That must be built before any production authenticity claims.

## Required production hardening
1. Separate organizations, stores, users, roles, and reviewer identities; scope every query and key to its tenant. The MVP uses one global merchant key and is **not suitable for multiple customers**.
2. Store document blobs in encrypted object storage with malware scanning, signed uploads, retention limits and access logging. Current API only stores hashes and references, not original files.
3. Add issuer verification, brand-authorized distributor directories, external authenticator partnerships, serial uniqueness rules, and human review queues.
4. Replace SQLite with PostgreSQL and transaction-safe immutable append-only audit events; sign public attestations using asymmetric keys with rotation and revocation.
5. Apply HTTPS, WAF, per-tenant quotas, rate limiting, key rotation, vault-managed secrets, logging, monitoring, backup/restore, security tests, and privacy review.
6. Use independent reviewer access (MFA, least privilege), two-person approval for high-value items, fraud investigations and dispute/revocation workflows.
7. Prevent SSRF by allowlisting service hosts in commerce integrations; disable unsafe redirects, and protect API tokens. Cache public statuses briefly and revoke quickly.
8. Review trademark, endorsement, consumer protection, privacy, and product-liability issues with counsel. Never use a manufacturer's logo without authorization.

## Known MVP gaps
- Reviewer can be anyone holding a static reviewer key; uploaded evidence hash does not verify document truth.
- SKU is not an item-level unique identity; serialized products need a per-unit ID and transfer history.
- Public verification pages may be copied; signed QR/credential issuance is a roadmap feature.
- No merchant self-service billing, subscription enforcement, automated onboarding, or review dashboard yet.
- Magento module is read-only; Magento admin-side automatic registration and supplier metadata capture are future work.

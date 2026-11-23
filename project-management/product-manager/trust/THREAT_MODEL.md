# Threat model — minimum security review
**Assets:** reviewer authority, signing keys, private evidence, identity, public records, payment data, custody chain. **Threats:** forged badges, merchant self-approval, ID swapping, replayed signatures, stolen keys, fraudulent uploads, account takeover, manipulated shipping events, evidence exfiltration, denial of service, fake demo records mistaken for production.

**Controls:** strict service authorization, dual control for critical decisions, signed tokens bound to item/merchant/status/expiry, live revocation lookup, key rotation, audit append-only store, evidence hashes, malware scan, rate limits, least privilege, penetration tests, secret scanning, backup restore tests.

**Abuse cases to test:** replace item ID; copy verified badge to another product; revoke record while cached; forge `DEMO_VERIFIED` as `VERIFIED`; view evidence across tenants; replay an expired signature; issue approval as merchant; remove audit event. Fail closed and alert.

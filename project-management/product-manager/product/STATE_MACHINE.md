# Verification state machine — normative proposal
UNVERIFIED → SUBMITTED → PENDING_REVIEW → NEEDS_EVIDENCE / INCONCLUSIVE / REJECTED / VERIFIED. VERIFIED → EXPIRED / DISPUTED / REVOKED; DISPUTED → VERIFIED only after documented independent re-review. Demo states are a separate namespace (`DEMO_VERIFIED`) and must never pass production validation.

**Display policy:** Only current signed production VERIFIED with matching item ID, nonexpired status, and no dispute/revocation may show a real verified badge. Other statuses display their actual status, with clear 'view record' link. On lookup failure, do not show green approval. No approval may be inferred from the presence of an M logo.

**Required record fields:** record ID, item ID, merchant ID, method, reviewer role, evidence hash, issued at, expiry, current status, revocation reason (privacy-safe), signature key ID, public URL. Never expose buyer identity or confidential source evidence.

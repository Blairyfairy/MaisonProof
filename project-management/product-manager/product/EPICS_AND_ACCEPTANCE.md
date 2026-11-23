# End-to-end epics and acceptance criteria
1. **Identity / merchant onboarding:** verified merchant and role separation; no merchant-issued approvals.
2. **Item registry:** unique immutable item ID, evidence hashes, duplicate detection; wrong-item badge denied.
3. **Remote triage:** consent, file validation, reviewer request, method limitation, escalate-to-physical path.
4. **Physical inspection:** declared value, insured-carrier terms after contract, chain-of-custody events, exception handling.
5. **Expert review:** credentialed reviewers, conflict checks, second review for high risk, recorded rationale.
6. **Decision & certificate:** signed item-bound status, issue/expiry, method, limitations, issuer, revocation, dispute; cryptographic verification.
7. **Commerce badges:** states NOT_VERIFIED, PENDING, DEMO_VERIFIED (demo only), VERIFIED (production only), INCONCLUSIVE, REJECTED, EXPIRED, REVOKED, DISPUTED; fail closed on unknown/error.
8. **Public record:** privacy-safe buyer view, status freshness, status change history, tamper warning and accessibility.
9. **Billing:** fee quote, charge, refund, invoice, taxes, chargeback and reconciliation.
10. **Admin & support:** RBAC, evidence access log, dispute SLA, abuse handling, export/delete policies.

**Cross-cutting DoD:** tests pass, threat model reviewed, accessibility WCAG 2.2 AA checked, audit logs, monitoring, privacy assessment, operational runbook, rollback, stakeholder acceptance. Production approval must be backed by real reviewer evidence; the demo cannot mint it.

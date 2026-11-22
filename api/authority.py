"""Conservative trust-policy prototype. Inputs must come from a trusted backend, not merchants."""

VALID_AUTHORITY = {'manufacturer', 'authorized_brand_agent', 'independent_authenticator'}

def evaluate_authentication(record):
    """Never grant authenticated status from seller claims or identifiers alone.

    WARNING: flags here are trusted-backend assertions, not independently verified
    by this function. Production must verify signatures, issuer identity and scope,
    evidence binding, revocation and conflicts against authoritative services.
    """
    if record.get('is_demo') or record.get('revoked') or record.get('disputed'):
        return 'revoked_or_disputed' if record.get('revoked') or record.get('disputed') else 'unverified'
    evidence = record.get('evidence') or []
    qualified = any(
        e.get('authority_type') in VALID_AUTHORITY
        and e.get('issuer_identity_verified') is True
        and e.get('issuer_scope_verified') is True
        and e.get('attestation_signature_verified') is True
        and e.get('product_binding_verified') is True
        and e.get('revocation_checked') is True
        and e.get('revoked') is False
        and e.get('conflict_checked') is True
        and e.get('conflict_found') is False
        and e.get('authentication_conclusion') == 'authentic'
        for e in evidence
    )
    # MaisonProof is the final certifying authority for the MaisonProof seal.
    # Merchant input or external reports never directly activate the seal.
    approval = record.get('maisonproof_approval') or {}
    approved = (approval.get('decision') == 'approved'
                and approval.get('reviewer_verified') is True
                and approval.get('product_id') == record.get('id')
                and bool(approval.get('decision_id'))
                and bool(approval.get('approved_at'))
                and approval.get('revoked') is False)
    # MaisonProof may also approve after its own documented physical inspection.
    # This flag must originate from an authenticated, audited reviewer backend.
    physical = (record.get('maisonproof_inspection') or {})
    inspected = (physical.get('qualified_inspector_verified') is True
                 and physical.get('physical_item_binding_verified') is True
                 and physical.get('inspection_conclusion') == 'authentic'
                 and physical.get('conflict_checked') is True
                 and physical.get('conflict_found') is False
                 and bool(physical.get('inspection_report_id')))
    if (qualified or inspected) and approved:
        return 'authenticated'
    if any(e.get('reviewed_by_verified_reviewer') is True for e in evidence):
        return 'evidence_reviewed'
    return 'unverified'

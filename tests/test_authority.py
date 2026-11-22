from api.authority import evaluate_authentication

def test_seller_claim_cannot_authenticate():
    assert evaluate_authentication({'evidence': [{'type': 'seller_statement', 'authentication_conclusion': 'authentic'}]}) == 'unverified'

def test_unverified_signature_cannot_authenticate():
    assert evaluate_authentication({'evidence': [{'authority_type': 'manufacturer', 'authentication_conclusion': 'authentic'}]}) == 'unverified'

def test_trusted_backend_assertions_required():
    evidence = dict(authority_type='manufacturer', issuer_identity_verified=True,
        issuer_scope_verified=True, attestation_signature_verified=True,
        product_binding_verified=True, revocation_checked=True, revoked=False,
        conflict_checked=True, conflict_found=False, authentication_conclusion='authentic')
    assert evaluate_authentication({'evidence': [evidence]}) == 'unverified'
    approval = dict(decision='approved', reviewer_verified=True, product_id='LP-123', decision_id='DEC-123', approved_at='2026-11-22T00:00:00Z', revoked=False)
    assert evaluate_authentication({'id':'LP-123', 'evidence': [evidence], 'maisonproof_approval':approval}) == 'authenticated'
    assert evaluate_authentication({'evidence': [evidence], 'disputed': True}) == 'revoked_or_disputed'
    assert evaluate_authentication({'evidence': [evidence], 'is_demo': True}) == 'unverified'

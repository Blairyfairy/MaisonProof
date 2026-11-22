import pytest
from api.cases import Case

def test_shipment_route_requires_review_before_seal():
    case = Case('C-1', 'ITEM-1', 'shipment')
    assert not case.storefront_seal_eligible
    case.submit_evidence('physical-inspection:report-1')
    case.status = 'under_review'  # illustrative intake action; not a public endpoint
    case.decide('approved', 'reviewer-1', 'decision-1', True)
    assert case.storefront_seal_eligible

def test_remote_correspondence_and_video_consent():
    case = Case('C-2', 'ITEM-2', 'remote')
    case.request_evidence('Show close-up of hallmark on live video', 'reviewer-1')
    assert not case.storefront_seal_eligible
    with pytest.raises(ValueError):
        case.log_consented_video('recording:1', False)
    case.log_consented_video('recording:1', True)
    assert case.status == 'under_review'
    assert not case.storefront_seal_eligible
    case.decide('inconclusive', 'reviewer-1', 'decision-2', True)
    assert not case.storefront_seal_eligible

def test_existing_certificate_not_auto_approved():
    case = Case('C-3', 'ITEM-3', 'remote')
    case.submit_evidence('third-party-certificate:123')
    assert not case.storefront_seal_eligible

def test_physical_escalation():
    case = Case('C-4', 'ITEM-4', 'remote', status='under_review')
    case.request_physical_inspection('reviewer-1')
    assert case.status == 'physical_inspection_required'
    assert not case.storefront_seal_eligible

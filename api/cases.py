"""MaisonProof case workflow domain model (in-memory examples only).

This module defines validation and transitions, not an operational reviewer portal.
Production must enforce authenticated roles, signed decisions, secure evidence storage,
recording consent, case ownership, and tamper-evident audit logging server-side.
"""
from dataclasses import dataclass, field
from datetime import datetime, timezone
from typing import List

ROUTES = {'shipment', 'remote'}
STATES = {'submitted', 'intake', 'awaiting_evidence', 'under_review',
          'physical_inspection_required', 'approved', 'rejected', 'inconclusive',
          'suspended', 'revoked'}

@dataclass
class Event:
    action: str
    actor_role: str
    note: str
    at: str = field(default_factory=lambda: datetime.now(timezone.utc).isoformat())

@dataclass
class Case:
    case_id: str
    product_id: str
    route: str
    status: str = 'submitted'
    evidence_references: List[str] = field(default_factory=list)
    events: List[Event] = field(default_factory=list)
    reviewer_id: str = ''
    decision_id: str = ''
    recording_consent: bool = False

    def __post_init__(self):
        if self.route not in ROUTES:
            raise ValueError('Unsupported authentication route')

    def submit_evidence(self, reference: str, actor_role: str = 'merchant'):
        if self.status in {'approved', 'rejected', 'revoked', 'suspended'}:
            raise ValueError('Case closed or suspended')
        if not reference or len(reference) > 200:
            raise ValueError('Evidence reference required')
        self.evidence_references.append(reference)
        self.events.append(Event('evidence_submitted', actor_role, reference))
        if self.status == 'awaiting_evidence':
            self.status = 'under_review'

    def request_evidence(self, instruction: str, reviewer_id: str):
        if self.status not in {'submitted', 'intake', 'under_review', 'awaiting_evidence'}:
            raise ValueError('Evidence request not allowed')
        if not reviewer_id or not instruction:
            raise ValueError('Reviewer and instruction required')
        self.status = 'awaiting_evidence'
        self.events.append(Event('evidence_requested', 'reviewer', instruction))

    def request_physical_inspection(self, reviewer_id: str):
        if not reviewer_id or self.status not in {'intake', 'under_review', 'awaiting_evidence'}:
            raise ValueError('Escalation not allowed')
        self.status = 'physical_inspection_required'
        self.events.append(Event('physical_inspection_required', 'reviewer', reviewer_id))

    def log_consented_video(self, reference: str, consent: bool):
        if self.route != 'remote' or not consent:
            raise ValueError('Remote video recording requires explicit consent')
        self.recording_consent = True
        self.submit_evidence(reference, 'merchant')
        self.events.append(Event('recording_consent', 'merchant', 'consent documented'))

    def decide(self, outcome: str, reviewer_id: str, decision_id: str, qualified_review: bool):
        if outcome not in {'approved', 'rejected', 'inconclusive'}:
            raise ValueError('Invalid decision')
        if self.status not in {'under_review', 'physical_inspection_required'}:
            raise ValueError('Case not ready for decision')
        if not reviewer_id or not decision_id or not qualified_review:
            raise ValueError('MaisonProof qualified reviewer and decision required')
        if outcome == 'approved' and not self.evidence_references:
            raise ValueError('Approval requires item-bound evidence')
        self.status = outcome
        self.reviewer_id = reviewer_id
        self.decision_id = decision_id
        self.events.append(Event('decision_' + outcome, 'maisonproof_reviewer', decision_id))

    @property
    def storefront_seal_eligible(self):
        # Illustrative case flag; production uses authoritative API decision,
        # identity-bound signatures, evidence checks, and revocation status.
        return self.status == 'approved' and bool(self.decision_id and self.reviewer_id)

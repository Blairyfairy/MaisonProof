import os
from html import escape
from fastapi import FastAPI, HTTPException
from fastapi.responses import HTMLResponse
from .authority import evaluate_authentication

app = FastAPI(title='MaisonProof Verification API', version='0.1.0')
RECORDS = {
    'DEMO-0001': {
        'id': 'DEMO-0001', 'product': 'Demonstration luxury item',
        'status': 'unverified', 'is_demo': True,
        'issuer': None, 'evidence': [
            {'type': 'seller_statement', 'issuer': 'Example seller (unverified)', 'status': 'unverified', 'reference': 'DEMO'}
        ], 'updated_at': '2026-11-22T00:00:00Z'
    }
}

@app.get('/health')
def health():
    return {'ok': True}

@app.get('/v1/records/{record_id}')
def record(record_id: str):
    item = RECORDS.get(record_id)
    if not item:
        raise HTTPException(status_code=404, detail='Verification record not found')
    return {**item, "status": evaluate_authentication(item), "badge_active": evaluate_authentication(item) == 'authenticated'}

@app.get('/verify/{record_id}', response_class=HTMLResponse)
def verify(record_id: str):
    item = RECORDS.get(record_id)
    if not item:
        raise HTTPException(status_code=404, detail='Verification record not found')
    item = {**item, 'status': evaluate_authentication(item)}
    rows = ''.join(f'<li>{escape(e["type"])} — {escape(e["issuer"])} ({escape(e["status"])})</li>' for e in item['evidence'])
    return f'''<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>MaisonProof | {escape(record_id)}</title><style>body{{font:16px system-ui;background:#111827;color:#f9fafb;max-width:700px;margin:8vh auto;padding:24px}}main{{border:1px solid #475569;border-radius:18px;padding:28px}}.status{{color:#fbbf24}}a{{color:#93c5fd}}</style></head><body><main><h1>MaisonProof</h1><p>Verification record: {escape(record_id)}</p><h2>{escape(item['product'])}</h2><p class="status">Status: {escape(item['status'].upper())}</p><p><strong>Demo record — not proof of authenticity.</strong></p><p>MaisonProof intends to evaluate item-bound evidence through shipment-based physical inspection with optional confirmed insurance coverage or remote guided review, including existing certificates, video, chat and follow-up correspondence. MaisonProof itself must review the case, approve the item, and issue its own product-bound approval before its authentication seal activates. A merchant claim, serial number or receipt alone does not qualify. This prototype has no live issuer integrations and cannot independently authenticate real goods.</p><h3>Chain of evidence</h3><ol>{rows}</ol><p>Last updated: {escape(item['updated_at'])}</p></main></body></html>'''

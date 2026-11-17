import os
import tempfile
os.environ['MAISONPROOF_DB'] = tempfile.mktemp(suffix='.sqlite3')
os.environ['MAISONPROOF_MERCHANT_KEY'] = 'm'*40
os.environ['MAISONPROOF_REVIEWER_KEY'] = 'r'*40
from fastapi.testclient import TestClient
from app import app
client=TestClient(app)

def test_authentication_workflow():
    p={'store':'shop','sku':'001','brand':'Brand','supplier_name':'Supplier'}
    assert client.post('/v1/products',json=p).status_code==401
    assert client.post('/v1/products',json=p,headers={'X-API-Key':'m'*40}).json()['status']=='unverified'
    review={'store':'shop','sku':'001','decision':'authenticated','reason':'Reviewed by independent expert'}
    assert client.post('/v1/reviews',json=review,headers={'X-Reviewer-Key':'r'*40}).status_code==422
    e={'store':'shop','sku':'001','type':'authentication_attestation','reference':'EXPERT-1','sha256':'a'*64}
    assert client.post('/v1/evidence',json=e,headers={'X-API-Key':'m'*40}).json()['authentication_granted'] is False
    assert client.post('/v1/reviews',json=review,headers={'X-Reviewer-Key':'r'*40}).json()['status']=='authenticated'
    assert client.get('/v1/public/shop/001').json()['status']=='authenticated'
    p['supplier_name']='Changed'
    assert client.post('/v1/products',json=p,headers={'X-API-Key':'m'*40}).json()['status']=='unverified'

from fastapi.testclient import TestClient
from api.main import app
client = TestClient(app)
def test_demo_is_unverified():
    r = client.get('/v1/records/DEMO-0001')
    assert r.status_code == 200
    assert r.json()['status'] == 'unverified'
def test_unknown_is_404():
    assert client.get('/v1/records/UNKNOWN').status_code == 404

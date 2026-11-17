"""MAISONPROOF MVP: central provenance registry; reviewer-only status elevation."""
import hashlib
import hmac
import os
import re
import sqlite3
import threading
from contextlib import contextmanager
from datetime import datetime, timezone
from pathlib import Path
from typing import Literal
from fastapi import FastAPI, Header, HTTPException, Query
from pydantic import BaseModel, Field

app = FastAPI(title="MAISONPROOF Verify API", version="0.1.0")
DB = os.getenv("MAISONPROOF_DB", str(Path(__file__).with_name("maisonproof.sqlite3")))
LOCK = threading.RLock()

def utc(): return datetime.now(timezone.utc).isoformat()

@contextmanager
def db():
    with LOCK:
        conn = sqlite3.connect(DB, timeout=15)
        conn.row_factory = sqlite3.Row
        try:
            conn.execute("PRAGMA foreign_keys=ON")
            yield conn
            conn.commit()
        finally: conn.close()

def initialize():
    with db() as c:
        c.executescript("""
        CREATE TABLE IF NOT EXISTS products (store TEXT NOT NULL, sku TEXT NOT NULL, brand TEXT NOT NULL, supplier_name TEXT NOT NULL, status TEXT NOT NULL DEFAULT 'unverified', updated_at TEXT NOT NULL, PRIMARY KEY(store,sku));
        CREATE TABLE IF NOT EXISTS evidence (id INTEGER PRIMARY KEY AUTOINCREMENT, store TEXT NOT NULL, sku TEXT NOT NULL, type TEXT NOT NULL, reference TEXT NOT NULL, sha256 TEXT NOT NULL, created_at TEXT NOT NULL, FOREIGN KEY(store,sku) REFERENCES products(store,sku));
        CREATE TABLE IF NOT EXISTS reviews (id INTEGER PRIMARY KEY AUTOINCREMENT, store TEXT NOT NULL, sku TEXT NOT NULL, decision TEXT NOT NULL, reason TEXT NOT NULL, created_at TEXT NOT NULL, FOREIGN KEY(store,sku) REFERENCES products(store,sku));
        """)
initialize()

class Product(BaseModel):
    store: str = Field(min_length=1,max_length=100,pattern=r"^[A-Za-z0-9_-]+$")
    sku: str = Field(min_length=1,max_length=120)
    brand: str = Field(min_length=1,max_length=160)
    supplier_name: str = Field(min_length=1,max_length=200)
class Evidence(BaseModel):
    store: str = Field(min_length=1,max_length=100,pattern=r"^[A-Za-z0-9_-]+$")
    sku: str = Field(min_length=1,max_length=120)
    type: Literal['invoice','supplier_contract','serial_record','authentication_attestation','other']
    reference: str = Field(min_length=1,max_length=300)
    sha256: str = Field(pattern=r'^[a-fA-F0-9]{64}$')
class Review(BaseModel):
    store: str = Field(min_length=1,max_length=100,pattern=r"^[A-Za-z0-9_-]+$")
    sku: str = Field(min_length=1,max_length=120)
    decision: Literal['unverified','documents_received','supplier_verified','authenticated','rejected']
    reason: str = Field(min_length=10,max_length=1000)

def auth(value, env):
    secret = os.getenv(env, '')
    if len(secret) < 32 or not value or not hmac.compare_digest(value,secret):
        raise HTTPException(401, 'Invalid credentials or missing server configuration')

def get_product(c,store,sku):
    return c.execute('SELECT * FROM products WHERE store=? AND sku=?',(store,sku)).fetchone()

@app.get('/health')
def health(): return {'ok': True}

@app.post('/v1/products')
def upsert_product(p: Product, x_api_key: str | None = Header(default=None)):
    auth(x_api_key,'MAISONPROOF_MERCHANT_KEY')
    with db() as c:
        old = get_product(c,p.store,p.sku)
        if old:
            # Changes to supplier/brand invalidate previous verification.
            changed = old['brand'] != p.brand or old['supplier_name'] != p.supplier_name
            status = 'unverified' if changed else old['status']
            c.execute('UPDATE products SET brand=?,supplier_name=?,status=?,updated_at=? WHERE store=? AND sku=?', (p.brand,p.supplier_name,status,utc(),p.store,p.sku))
            if changed: c.execute('INSERT INTO reviews(store,sku,decision,reason,created_at) VALUES (?,?,?,?,?)',(p.store,p.sku,'unverified','Identity or supplier changed; re-review required',utc()))
        else:
            c.execute('INSERT INTO products VALUES (?,?,?,?,?,?)',(p.store,p.sku,p.brand,p.supplier_name,'unverified',utc()))
    return {'store':p.store,'sku':p.sku,'status':status if old else 'unverified'}

@app.post('/v1/evidence')
def add_evidence(e: Evidence, x_api_key: str | None = Header(default=None)):
    auth(x_api_key,'MAISONPROOF_MERCHANT_KEY')
    with db() as c:
        if not get_product(c,e.store,e.sku): raise HTTPException(404,'Product not found')
        c.execute('INSERT INTO evidence(store,sku,type,reference,sha256,created_at) VALUES (?,?,?,?,?,?)',(e.store,e.sku,e.type,e.reference,e.sha256.lower(),utc()))
        # New evidence alone never grants authentication.
        c.execute("UPDATE products SET status='documents_received',updated_at=? WHERE store=? AND sku=? AND status='unverified'",(utc(),e.store,e.sku))
    return {'accepted':True,'authentication_granted':False}

@app.post('/v1/reviews')
def review(r: Review, x_reviewer_key: str | None = Header(default=None)):
    auth(x_reviewer_key,'MAISONPROOF_REVIEWER_KEY')
    with db() as c:
        if not get_product(c,r.store,r.sku): raise HTTPException(404,'Product not found')
        if r.decision=='authenticated':
            row=c.execute("SELECT COUNT(*) AS n FROM evidence WHERE store=? AND sku=? AND type='authentication_attestation'",(r.store,r.sku)).fetchone()
            if row['n']==0: raise HTTPException(422,'Independent authentication attestation required')
        c.execute('UPDATE products SET status=?,updated_at=? WHERE store=? AND sku=?',(r.decision,utc(),r.store,r.sku))
        c.execute('INSERT INTO reviews(store,sku,decision,reason,created_at) VALUES (?,?,?,?,?)',(r.store,r.sku,r.decision,r.reason,utc()))
    return {'status':r.decision}

@app.get('/v1/public/{store}/{sku}')
def public_status(store: str,sku: str):
    if not re.fullmatch(r'[A-Za-z0-9_-]{1,100}',store): raise HTTPException(400,'Invalid store')
    with db() as c:
        p=get_product(c,store,sku)
        if not p: raise HTTPException(404,'Product not found')
        return {'store':p['store'],'sku':p['sku'],'brand':p['brand'],'status':p['status'],'updated_at':p['updated_at'], 'message': {'authenticated':'Independent authentication review recorded','supplier_verified':'Supplier documentation reviewed; item authenticity not established','documents_received':'Documentation submitted; not authenticated','unverified':'Not verified','rejected':'Verification rejected'}[p['status']]}

@app.get('/v1/private/{store}/{sku}')
def private_status(store: str,sku: str,x_api_key: str | None = Header(default=None)):
    auth(x_api_key,'MAISONPROOF_MERCHANT_KEY')
    with db() as c:
        p=get_product(c,store,sku)
        if not p: raise HTTPException(404,'Product not found')
        return {'product':dict(p),'evidence':[dict(x) for x in c.execute('SELECT * FROM evidence WHERE store=? AND sku=?',(store,sku))],'reviews':[dict(x) for x in c.execute('SELECT * FROM reviews WHERE store=? AND sku=?',(store,sku))]}

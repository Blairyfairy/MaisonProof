import os,json,time,hmac,hashlib,uuid,datetime
import boto3
from botocore.exceptions import ClientError
T=boto3.resource('dynamodb').Table(os.environ['TABLE'])
def reply(code,obj):
 return {'statusCode':code,'headers':{'content-type':'application/json','cache-control':'no-store','x-content-type-options':'nosniff'},'body':json.dumps(obj)}
def body_of(e):
 try: return json.loads(e.get('body') or '{}')
 except (ValueError,TypeError): return None
def signed(e):
 h={k.lower():v for k,v in (e.get('headers') or {}).items()}; stamp=h.get('x-mp-timestamp',''); sig=h.get('x-mp-signature',''); store=h.get('x-mp-store','')
 if not stamp.isdigit() or abs(time.time()-int(stamp))>300 or not store or len(store)>80:return False
 msg=(stamp+'\n'+store+'\n'+(e.get('body') or '')).encode()
 expect=hmac.new(os.environ['STORE_KEY'].encode(),msg,hashlib.sha256).hexdigest()
 return hmac.compare_digest(sig,expect)
def handler(e,ctx):
 route=e.get('rawPath','');method=e.get('requestContext',{}).get('http',{}).get('method','GET'); headers={k.lower():v for k,v in (e.get('headers') or {}).items()}
 if method=='POST' and route=='/v1/submissions':
  if not signed(e):return reply(401,{'error':'invalid_signature'})
  data=body_of(e)
  if not isinstance(data,dict):return reply(400,{'error':'invalid_json'})
  store=headers.get('x-mp-store',''); sku=str(data.get('sku',''))[:128]; name=str(data.get('name',''))[:240]; source=str(data.get('source',''))[:40]
  if not sku or not name or source not in ('woocommerce','magento'):return reply(422,{'error':'sku_name_source_required'})
  idem=headers.get('idempotency-key','')
  if not (1<=len(idem)<=128 and all(c.isalnum() or c in '-_:' for c in idem)):return reply(422,{'error':'idempotency_key_required'})
  pk='submission#'+hashlib.sha256((store+':'+idem).encode()).hexdigest()
  now=datetime.datetime.now(datetime.timezone.utc).isoformat();rid=uuid.uuid4().hex
  try:
   T.put_item(Item={'pk':pk,'id':rid,'store':store,'sku':sku,'name':name,'source':source,'status':'pending','created_at':now,'updated_at':now},ConditionExpression='attribute_not_exists(pk)')
  except ClientError as ex:
   if ex.response['Error']['Code']!='ConditionalCheckFailedException':raise
   existing=T.get_item(Key={'pk':pk},ConsistentRead=True).get('Item',{})
   if existing.get('sku')!=sku or existing.get('store')!=store:return reply(409,{'error':'idempotency_conflict'})
   return reply(200,{'id':existing['id'],'status':existing['status']})
  T.put_item(Item={'pk':'record#'+rid,'submission_pk':pk,'status':'pending','store':store,'sku':sku,'name':name,'source':source,'created_at':now,'updated_at':now})
  return reply(202,{'id':rid,'status':'pending'})
 parts=route.strip('/').split('/')
 if len(parts)>=3 and parts[:2]==['v1','records'] and len(parts[2])==32 and all(c in '0123456789abcdef' for c in parts[2]):
  rid=parts[2]; key={'pk':'record#'+rid};r=T.get_item(Key=key,ConsistentRead=True).get('Item')
  if not r:return reply(404,{'error':'not_found'})
  if method=='GET' and len(parts)==3:return reply(200,{k:r[k] for k in ('id','status','name','sku','updated_at') if k in r}|{'id':rid})
  if method=='POST' and len(parts)==4 and parts[3]=='decision':
   if not hmac.compare_digest(headers.get('x-mp-reviewer-key',''),os.environ['REVIEWER_KEY']):return reply(403,{'error':'forbidden'})
   data=body_of(e)
   if not isinstance(data,dict) or data.get('status') not in ('in_review','verified','rejected','revoked'):return reply(422,{'error':'invalid_status'})
   status=data['status']; reviewer=str(data.get('reviewer',''))[:120]; evidence=str(data.get('evidence_reference',''))[:256]
   if not reviewer or (status=='verified' and not evidence):return reply(422,{'error':'reviewer_and_verification_evidence_required'})
   now=datetime.datetime.now(datetime.timezone.utc).isoformat()
   try:T.update_item(Key=key,UpdateExpression='SET #s=:s,updated_at=:t,reviewer=:r,evidence_reference=:e',ConditionExpression='attribute_exists(pk)',ExpressionAttributeNames={'#s':'status'},ExpressionAttributeValues={':s':status,':t':now,':r':reviewer,':e':evidence})
   except ClientError:return reply(409,{'error':'update_failed'})
   T.put_item(Item={'pk':'audit#'+rid+'#'+uuid.uuid4().hex,'record_id':rid,'status':status,'reviewer':reviewer,'at':now})
   return reply(200,{'id':rid,'status':status})
 return reply(404,{'error':'not_found'})

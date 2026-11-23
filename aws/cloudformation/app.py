import os,json,time,hmac,hashlib,uuid,datetime,re,base64
import boto3
from botocore.exceptions import ClientError
D=boto3.client('dynamodb');Q=boto3.client('sqs');S=boto3.client('secretsmanager');TABLE=os.environ['TABLE']
_secret=None
def secret():
 global _secret
 if _secret is None:_secret=S.get_secret_value(SecretId=os.environ['STORE_SECRET_ARN'])['SecretString']
 return _secret

def response(code,body):return {'statusCode':code,'headers':{'content-type':'application/json','cache-control':'no-store','x-content-type-options':'nosniff'},'body':json.dumps(body)}
def get(headers,key):return headers.get(key,'')
def handler(event,context):
 try:return handle(event)
 except Exception as ex:
  print('request_failed',type(ex).__name__)
  return response(500,{'error':'internal_error'})
def handle(e):
 route=e.get('rawPath','');method=e.get('requestContext',{}).get('http',{}).get('method','GET');h={k.lower():v for k,v in (e.get('headers') or {}).items()}
 if method=='POST' and route=='/v1/submissions':
  stamp=get(h,'x-mp-timestamp');store=get(h,'x-mp-store');sig=get(h,'x-mp-signature');raw=e.get('body') or ''
  if e.get('isBase64Encoded'):raw=base64.b64decode(raw).decode()
  if not stamp.isdigit() or abs(time.time()-int(stamp))>300 or not re.fullmatch('[a-zA-Z0-9_-]{1,80}',store):return response(401,{'error':'invalid_signature'})
  expected=hmac.new(secret().encode(),(stamp+'\n'+store+'\n'+raw).encode(),hashlib.sha256).hexdigest()
  if not hmac.compare_digest(sig,expected):return response(401,{'error':'invalid_signature'})
  if len(raw)>32000:return response(413,{'error':'payload_too_large'})
  try:data=json.loads(raw)
  except ValueError:return response(400,{'error':'invalid_json'})
  if not isinstance(data,dict):return response(400,{'error':'invalid_json'})
  sku=data.get('sku');name=data.get('name');source=data.get('source');idem=get(h,'idempotency-key')
  if not isinstance(sku,str) or not 1<=len(sku)<=128 or not isinstance(name,str) or not 1<=len(name)<=240 or source not in ('woocommerce','magento') or not re.fullmatch('[A-Za-z0-9_:-]{1,128}',idem):return response(422,{'error':'invalid_submission'})
  idemkey=hashlib.sha256((store+':'+idem).encode()).hexdigest();rid=uuid.uuid4().hex;now=datetime.datetime.now(datetime.timezone.utc).isoformat()
  record={'pk':{'S':'RECORD#'+rid},'sk':{'S':'META'},'id':{'S':rid},'store':{'S':store},'sku':{'S':sku},'name':{'S':name},'source':{'S':source},'status':{'S':'pending'},'created_at':{'S':now},'updated_at':{'S':now}}
  try:
   D.transact_write_items(TransactItems=[{'Put':{'TableName':TABLE,'Item':{'pk':{'S':'IDEMP#'+idemkey},'sk':{'S':'META'},'id':{'S':rid},'sku':{'S':sku},'store':{'S':store}},'ConditionExpression':'attribute_not_exists(pk)'}},{'Put':{'TableName':TABLE,'Item':record,'ConditionExpression':'attribute_not_exists(pk)'}}])
  except D.exceptions.TransactionCanceledException:
   old=D.get_item(TableName=TABLE,Key={'pk':{'S':'IDEMP#'+idemkey},'sk':{'S':'META'}},ConsistentRead=True).get('Item')
   if old and old.get('sku',{}).get('S')==sku:return response(200,{'id':old['id']['S'],'status':'pending'})
   return response(409,{'error':'idempotency_conflict'})
  try:Q.send_message(QueueUrl=os.environ['QUEUE_URL'],MessageBody=json.dumps({'record_id':rid,'store':store}))
  except ClientError:print('queue_send_failed',rid) # record persists and can be reconciled
  return response(202,{'id':rid,'status':'pending'})
 match=re.fullmatch(r'/v1/records/([0-9a-f]{32})(/decision)?',route)
 if match:
  rid=match.group(1);r=D.get_item(TableName=TABLE,Key={'pk':{'S':'RECORD#'+rid},'sk':{'S':'META'}},ConsistentRead=True).get('Item')
  if not r:return response(404,{'error':'not_found'})
  if method=='GET' and not match.group(2):return response(200,{'id':rid,'status':r['status']['S'],'updated_at':r['updated_at']['S']})
  if method=='POST' and match.group(2):
   claims=e.get('requestContext',{}).get('authorizer',{}).get('jwt',{}).get('claims',{})
   # JWT verified by API Gateway; application enforces reviewer group membership
   groups=claims.get('cognito:groups','');groups=groups if isinstance(groups,str) else json.dumps(groups)
   if 'MaisonProofReviewers' not in groups.split(',') and 'MaisonProofReviewers' not in groups.strip('[]').replace(' ','').split(','):return response(403,{'error':'reviewer_group_required'})
   try:data=json.loads(e.get('body') or '{}')
   except ValueError:return response(400,{'error':'invalid_json'})
   status=data.get('status');evidence=data.get('evidence_reference','')
   if status not in ('in_review','verified','rejected','revoked') or (status=='verified' and (not isinstance(evidence,str) or not 1<=len(evidence)<=256)):return response(422,{'error':'invalid_decision'})
   prior=r['status']['S'];allowed={'pending':['in_review','rejected'],'in_review':['verified','rejected'],'verified':['revoked'],'rejected':['in_review'],'revoked':[]}
   if status not in allowed.get(prior,[]):return response(409,{'error':'invalid_transition'})
   now=datetime.datetime.now(datetime.timezone.utc).isoformat();actor=claims.get('sub','unknown');auditid=uuid.uuid4().hex
   try:D.transact_write_items(TransactItems=[{'Update':{'TableName':TABLE,'Key':{'pk':{'S':'RECORD#'+rid},'sk':{'S':'META'}},'UpdateExpression':'SET #status=:next,updated_at=:now,reviewer=:actor,evidence_reference=:evidence','ConditionExpression':'#status=:prior','ExpressionAttributeNames':{'#status':'status'},'ExpressionAttributeValues':{':next':{'S':status},':prior':{'S':prior},':now':{'S':now},':actor':{'S':actor},':evidence':{'S':str(evidence)[:256]}}}},{'Put':{'TableName':TABLE,'Item':{'pk':{'S':'RECORD#'+rid},'sk':{'S':'AUDIT#'+now+'#'+auditid},'status':{'S':status},'reviewer':{'S':actor},'at':{'S':now}}}}])
   except D.exceptions.TransactionCanceledException:return response(409,{'error':'concurrent_change'})
   return response(200,{'id':rid,'status':status})
 return response(404,{'error':'not_found'})

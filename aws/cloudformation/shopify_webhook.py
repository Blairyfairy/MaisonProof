import os, json, base64, hmac, hashlib, uuid, datetime
import boto3
from botocore.exceptions import ClientError
D=boto3.client('dynamodb'); S=boto3.client('secretsmanager'); Q=boto3.client('sqs')

def reply(code,obj):
 return {'statusCode':code,'headers':{'content-type':'application/json','cache-control':'no-store'},'body':json.dumps(obj)}

def handler(event,context):
 h={k.lower():v for k,v in (event.get('headers') or {}).items()}
 raw=event.get('body') or ''
 raw=base64.b64decode(raw) if event.get('isBase64Encoded') else raw.encode('utf-8')
 if len(raw)>1024*1024:return reply(413,{'error':'too_large'})
 shop=h.get('x-shopify-shop-domain','').lower();allowed=set(x.strip().lower() for x in os.environ['ALLOWED_SHOPS'].split(',') if x.strip())
 if shop not in allowed or not shop.endswith('.myshopify.com'):return reply(403,{'error':'shop_not_allowed'})
 secret=S.get_secret_value(SecretId=os.environ['SHOPIFY_SECRET_ARN'])['SecretString']
 expected=base64.b64encode(hmac.new(secret.encode(),raw,hashlib.sha256).digest()).decode()
 if not hmac.compare_digest(h.get('x-shopify-hmac-sha256',''),expected):return reply(401,{'error':'invalid_signature'})
 topic=h.get('x-shopify-topic','');wid=h.get('x-shopify-webhook-id','')
 if topic not in ('products/create','products/update') or not wid or len(wid)>128:return reply(400,{'error':'unsupported_webhook'})
 try:product=json.loads(raw)
 except (ValueError,UnicodeDecodeError):return reply(400,{'error':'invalid_json'})
 pid=str(product.get('id',''));name=product.get('title','')
 if not pid.isdigit() or not isinstance(name,str) or not 1<=len(name)<=240:return reply(422,{'error':'invalid_product'})
 key=hashlib.sha256((shop+':'+wid).encode()).hexdigest();rid=uuid.uuid4().hex;now=datetime.datetime.now(datetime.timezone.utc).isoformat()
 item={'pk':{'S':'RECORD#'+rid},'sk':{'S':'META'},'id':{'S':rid},'store':{'S':shop},'sku':{'S':pid},'name':{'S':name},'source':{'S':'shopify'},'status':{'S':'pending'},'created_at':{'S':now},'updated_at':{'S':now}}
 try:
  D.transact_write_items(TransactItems=[{'Put':{'TableName':os.environ['TABLE'],'Item':{'pk':{'S':'IDEMP#'+key},'sk':{'S':'META'},'id':{'S':rid}},'ConditionExpression':'attribute_not_exists(pk)'}},{'Put':{'TableName':os.environ['TABLE'],'Item':item,'ConditionExpression':'attribute_not_exists(pk)'}}])
 except D.exceptions.TransactionCanceledException:return reply(200,{'accepted':True,'duplicate':True})
 try:Q.send_message(QueueUrl=os.environ['QUEUE_URL'],MessageBody=json.dumps({'record_id':rid,'store':shop,'source':'shopify'}))
 except ClientError:print('queue_enqueue_failed',rid) # reconciliation required
 return reply(202,{'accepted':True,'record_id':rid,'status':'pending'})

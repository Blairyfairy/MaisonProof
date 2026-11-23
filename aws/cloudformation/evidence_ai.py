"""S3 evidence intake: optional Bedrock visual triage, never authenticity certification."""
import os,json,hashlib,datetime,boto3
D=boto3.client('dynamodb'); S=boto3.client('s3'); B=boto3.client('bedrock-runtime')
PROMPT=("You are a quality-control assistant for a luxury-item evidence photograph. "
"Report image clarity, visibility of identifying details, signs of editing, and missing angles. "
"Never conclude genuine, counterfeit, verified, or assign authenticity probability. "
"Return JSON with keys quality (pass/review), issues (array), recommended_photos (array).")
def handler(event,context):
 failures=[]
 for entry in event.get('Records',[]):
  try:
   msg=json.loads(entry['body']) if 'body' in entry else entry
   events=msg.get('Records',[])
   if msg.get('source')=='aws.s3' and msg.get('detail-type')=='Object Created':
    events=[{'s3':{'bucket':{'name':msg['detail']['bucket']['name']},'object':{'key':msg['detail']['object']['key']}}}]
   for rec in events:
    bucket=rec['s3']['bucket']['name']; key=rec['s3']['object']['key']
    from urllib.parse import unquote_plus
    key=unquote_plus(key)
    parts=key.split('/')
    if len(parts)!=3 or parts[0]!='evidence' or not __import__('re').fullmatch('[0-9a-f]{32}',parts[1]):continue
    rid=parts[1]; obj=S.get_object(Bucket=bucket,Key=key)
    content=obj['Body'].read(8*1024*1024+1); mime=obj.get('ContentType','')
    if len(content)>8*1024*1024 or mime not in ('image/jpeg','image/png','image/webp'):
     raise ValueError('unsupported_image')
    sha=hashlib.sha256(content).hexdigest(); result={'quality':'review','issues':['Manual examination required'],'recommended_photos':[],'engine':'manual'}
    if os.environ.get('ENABLE_BEDROCK','false')=='true':
     try:
      model=os.environ['BEDROCK_MODEL_ID']
      out=B.converse(modelId=model,messages=[{'role':'user','content':[{'text':PROMPT},{'image':{'format':mime.split('/')[-1].replace('jpeg','jpeg'),'source':{'bytes':content}}}]}],inferenceConfig={'maxTokens':650,'temperature':0})
      answer=' '.join(x.get('text','') for x in out['output']['message']['content']); result={'quality':'review','issues':[],'recommended_photos':[],'engine':'bedrock','raw_advisory':answer[:5000]}
     except Exception as ex: result['issues']=['AI unavailable; manual review required'];result['error_type']=type(ex).__name__
    now=datetime.datetime.now(datetime.timezone.utc).isoformat()
    D.put_item(TableName=os.environ['TABLE'],Item={'pk':{'S':'RECORD#'+rid},'sk':{'S':'EVIDENCE#'+sha},'sha256':{'S':sha},'s3_key':{'S':key},'mime':{'S':mime},'at':{'S':now},'advisory':{'S':json.dumps(result)[:9000]}},ConditionExpression='attribute_not_exists(pk) AND attribute_not_exists(sk)')
  except D.exceptions.ConditionalCheckFailedException:pass
  except Exception as ex:
   print('evidence_processing_error',type(ex).__name__)
   if 'messageId' in entry:failures.append({'itemIdentifier':entry['messageId']})
 return {'batchItemFailures':failures}

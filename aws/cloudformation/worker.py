import json,os,boto3,datetime
D=boto3.client('dynamodb')
def handler(event,context):
 failures=[]
 for entry in event.get('Records',[]):
  try:
   item=json.loads(entry['body']);rid=item['record_id']
   # Deliberately no automatic verification. Queue processing only records receipt.
   D.update_item(TableName=os.environ['TABLE'],Key={'pk':{'S':'RECORD#'+rid},'sk':{'S':'META'}},UpdateExpression='SET queued_at=if_not_exists(queued_at,:now)',ConditionExpression='attribute_exists(pk)',ExpressionAttributeValues={':now':{'S':datetime.datetime.now(datetime.timezone.utc).isoformat()}})
  except Exception:
   failures.append({'itemIdentifier':entry['messageId']})
 return {'batchItemFailures':failures}

# Run with boto3 installed: python -m unittest test_shopify_webhook.py
import unittest,os,sys,types,json,base64,hmac,hashlib,importlib
class FakeD:
 class exceptions:
  class TransactionCanceledException(Exception):pass
 def transact_write_items(self,**kw):self.last=kw
class FakeS:
 def get_secret_value(self,**kw):return {'SecretString':'test-secret'}
class FakeQ:
 def send_message(self,**kw):self.last=kw
class TestWebhook(unittest.TestCase):
 def setUp(self):
  self.d,self.s,self.q=FakeD(),FakeS(),FakeQ()
  sys.modules['boto3']=types.SimpleNamespace(client=lambda x:{'dynamodb':self.d,'secretsmanager':self.s,'sqs':self.q}[x])
  botocore=types.ModuleType('botocore');exc=types.ModuleType('botocore.exceptions');exc.ClientError=Exception;sys.modules['botocore']=botocore;sys.modules['botocore.exceptions']=exc
  os.environ.update(TABLE='t',QUEUE_URL='q',SHOPIFY_SECRET_ARN='s',ALLOWED_SHOPS='valid.myshopify.com')
  sys.modules.pop('shopify_webhook',None);self.mod=importlib.import_module('shopify_webhook')
 def event(self,valid=True):
  body=json.dumps({'id':123,'title':'Test'});sig=base64.b64encode(hmac.new(b'test-secret',body.encode(),hashlib.sha256).digest()).decode()
  return {'body':body,'headers':{'X-Shopify-Shop-Domain':'valid.myshopify.com','X-Shopify-Topic':'products/update','X-Shopify-Webhook-Id':'wh-1','X-Shopify-Hmac-Sha256':sig if valid else 'wrong'}}
 def test_accept(self):self.assertEqual(self.mod.handler(self.event(),None)['statusCode'],202)
 def test_bad_signature(self):self.assertEqual(self.mod.handler(self.event(False),None)['statusCode'],401)
 def test_wrong_shop(self):
  e=self.event();e['headers']['X-Shopify-Shop-Domain']='other.myshopify.com';self.assertEqual(self.mod.handler(e,None)['statusCode'],403)
if __name__=='__main__':unittest.main()

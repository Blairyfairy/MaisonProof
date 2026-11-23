<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Encryption\EncryptorInterface;
use Psr\Log\LoggerInterface;
class SubmitPublishedProduct implements ObserverInterface {
 public function __construct(private ScopeConfigInterface $config,private Curl $curl,private LoggerInterface $logger,private EncryptorInterface $encryptor) {}
 public function execute(Observer $observer): void {
  $product=$observer->getEvent()->getProduct();
  if (!$product || !$product->getId() || (int)$product->getStatus()!==1) return;
  if (!$this->config->isSetFlag('maisonproof/central/enabled'))return;
  $url=rtrim((string)$this->config->getValue('maisonproof/central/url'),'/');
  $store=(string)$this->config->getValue('maisonproof/central/store');$key=$this->encryptor->decrypt((string)$this->config->getValue('maisonproof/central/key'));
  if (!str_starts_with($url,'https://') || strlen($key)<32 || $store==='')return;
  $data=json_encode(['source'=>'magento','sku'=>(string)$product->getSku(),'name'=>(string)$product->getName()],JSON_UNESCAPED_SLASHES);
  $stamp=(string)time();$sig=hash_hmac('sha256',$stamp."\n".$store."\n".$data,$key);
  try {
   $this->curl->setTimeout(10);
   $this->curl->addHeader('Content-Type','application/json');
   $this->curl->addHeader('x-mp-store',$store);$this->curl->addHeader('x-mp-timestamp',$stamp);$this->curl->addHeader('x-mp-signature',$sig);
   $this->curl->addHeader('idempotency-key','mg-'.$product->getId().'-'.substr(hash('sha256',$data),0,40));
   $this->curl->post($url.'/v1/submissions',$data);
   if (!in_array($this->curl->getStatus(),[200,202],true))$this->logger->warning('MaisonProof central submission returned HTTP '.$this->curl->getStatus());
  }catch (\Throwable $e){$this->logger->warning('MaisonProof central submission failed');}
 }
}

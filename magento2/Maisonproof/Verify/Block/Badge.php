<?php
namespace Maisonproof\Verify\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Registry;
class Badge extends Template {
 private $config; private $curl; private $registry;
 public function __construct(Template\Context $context,ScopeConfigInterface $config,Curl $curl,Registry $registry,array $data=[]) {
  parent::__construct($context,$data);$this->config=$config;$this->curl=$curl;$this->registry=$registry;
 }
 public function getVerificationLabel() {
  $p=$this->registry->registry('current_product');if (!$p || !$p->getSku()) return 'Verification unavailable';
  $url=rtrim((string)$this->config->getValue('maisonproof_verify/general/api_url'),'/');
  $store=(string)$this->config->getValue('maisonproof_verify/general/store_id');
  if (!preg_match('#^https://#i',$url) || !preg_match('/^[A-Za-z0-9_-]+$/',$store)) return 'Verification unavailable';
  try {
   $this->curl->setTimeout(3);
   $this->curl->get($url.'/v1/public/'.rawurlencode($store).'/'.rawurlencode($p->getSku()));
   if ($this->curl->getStatus()!==200) return 'Verification unavailable';
   $d=json_decode($this->curl->getBody(),true);$status=$d['status']??'unverified';
   $labels=['authenticated'=>'Independently authenticated','supplier_verified'=>'Supplier reviewed — item not authenticated','documents_received'=>'Documents submitted — not authenticated','unverified'=>'Not authenticated','rejected'=>'Verification rejected'];
   return $labels[$status]??'Not authenticated';
  } catch (\Exception $e) {return 'Verification unavailable';}
 }
}

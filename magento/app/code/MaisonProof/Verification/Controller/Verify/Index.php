<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Controller\Verify;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use MaisonProof\Verification\Model\Lookup;
class Index implements HttpGetActionInterface {
 public function __construct(private ResultFactory $results,private RequestInterface $request,private Lookup $lookup) {}
 public function execute() {
  $id=(string)$this->request->getParam('id','');$data=$this->lookup->lookup($id);
  $result=$this->results->create(ResultFactory::TYPE_PAGE);
  $result->getConfig()->getTitle()->set('MaisonProof Verification');
  $result->getLayout()->getBlock('maisonproof.public.record')->setData('record_data',$data);
  return $result;
 }
}

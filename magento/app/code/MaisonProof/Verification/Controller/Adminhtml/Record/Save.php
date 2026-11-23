<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Controller\Adminhtml\Record;
use Magento\Backend\App\Action;
use MaisonProof\Verification\Model\RecordService;
use Magento\Catalog\Api\ProductRepositoryInterface;
class Save extends Action {
 public const ADMIN_RESOURCE='MaisonProof_Verification::manage';
 public function __construct(Action\Context $context,private RecordService $records,private ProductRepositoryInterface $products){parent::__construct($context);}
 public function execute(){
  $redirect=$this->resultRedirectFactory->create()->setPath('maisonproof/record/index');
  if (!$this->getRequest()->isPost()) return $redirect;
  try {
   if ($this->getRequest()->getParam('operation')==='create') {
    $id=(int)$this->getRequest()->getParam('product_id');$this->products->getById($id);$this->records->create($id);$this->messageManager->addSuccessMessage(__('Pending record created.'));
   } else {
    $this->records->update((int)$this->getRequest()->getParam('record_id'),(string)$this->getRequest()->getParam('status'),(string)$this->getRequest()->getParam('reviewer'),(string)$this->getRequest()->getParam('notes'),(string)$this->getRequest()->getParam('expires_at'));
    $this->messageManager->addSuccessMessage(__('Verification record updated.'));
   }
  }catch(\Throwable $e){$this->messageManager->addErrorMessage(__('Unable to save record. Check product ID and field values.'));}
  return $redirect;
 }
}

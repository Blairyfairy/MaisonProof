<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Controller\Adminhtml\Record;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
class Index extends Action {
 public const ADMIN_RESOURCE='MaisonProof_Verification::manage';
 public function execute() { $page=$this->resultFactory->create(ResultFactory::TYPE_PAGE);$page->getConfig()->getTitle()->prepend(__('MaisonProof Verification Records'));return $page; }
}

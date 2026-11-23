<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Block\Adminhtml;
use Magento\Backend\Block\Template;
use MaisonProof\Verification\Model\RecordService;
use Magento\Catalog\Api\ProductRepositoryInterface;
class Records extends Template {
 public function __construct(Template\Context $context,private RecordService $records,private ProductRepositoryInterface $products,array $data=[]) {parent::__construct($context,$data);}
 public function rows(): array {return $this->records->all();}
 public function productLabel(int $id): string {try{return (string)$this->products->getById($id)->getName();}catch(\Throwable $e){return 'Product #'.$id;}}
 public function postUrl(): string {return $this->getUrl('maisonproof/record/save');}
 public function publicUrl(string $id): string {return $this->getUrl('maisonproof/verify/index',['id'=>$id,'_nosid'=>true]);}
}

<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Plugin;
use Magento\Catalog\Block\Product\Image;
use MaisonProof\Verification\Model\RecordService;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
class ImageBadge {
 public function __construct(private RecordService $records,private Escaper $escaper,private UrlInterface $url) {}
 public function afterToHtml(Image $subject,string $html): string {
  $id=(int)$subject->getData('maisonproof_product_id');
  if (!$id || !$html || !($r=$this->records->verifiedForProduct($id))) return $html;
  $link=$this->escaper->escapeUrl($this->url->getUrl('maisonproof/verify/index',['id'=>$r['public_id']]));
  $badge='<a class="maisonproof-badge" href="'.$link.'" aria-label="View MaisonProof verification record"><span class="maisonproof-m">M</span><span>VERIFIED</span></a>';
  return '<span class="maisonproof-image-wrap">'.$html.$badge.'</span>';
 }
}

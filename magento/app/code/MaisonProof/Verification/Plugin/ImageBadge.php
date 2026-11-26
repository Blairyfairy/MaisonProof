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
  if (!$id || !$html) return $html;
  $r=$this->records->verifiedForProduct($id);
  $asset=$subject->getViewFileUrl('MaisonProof_Verification::images/maisonproof-'.($r?'verified':'not-verified').'.png');
  $img='<img class="mp-status-image" src="'.$this->escaper->escapeUrl($asset).'" alt="'.($r?'Verified':'Not verified').' — View record">';
  if (!$r) return '<span class="maisonproof-image-wrap">'.$html.'<span class="maisonproof-badge" title="No active verification record">'.$img.'</span></span>';
  $link=$this->escaper->escapeUrl($this->url->getUrl('maisonproof/verify/index',['id'=>$r['public_id']]));
  $badge='<a class="maisonproof-badge" href="'.$link.'" aria-label="View MaisonProof verification record">'.$img.'</a>';
  return '<span class="maisonproof-image-wrap">'.$html.$badge.'</span>';
 }
}

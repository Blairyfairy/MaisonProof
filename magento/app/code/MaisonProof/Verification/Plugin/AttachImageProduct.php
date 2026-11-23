<?php
declare(strict_types=1);
namespace MaisonProof\Verification\Plugin;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Image;
use Magento\Catalog\Model\Product;
class AttachImageProduct {
 public function afterGetImage(AbstractProduct $subject, Image $result, Product $product): Image {
  $result->setData('maisonproof_product_id', (int)$product->getId());return $result;
 }
}

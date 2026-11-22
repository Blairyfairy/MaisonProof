<?php
namespace MaisonProof\Verify\Block;
class Badge extends \Magento\Framework\View\Element\Template {
    public function getVerificationId(): string {
        $product = \Magento\Framework\App\ObjectManager::getInstance()->get(\Magento\Framework\Registry::class)->registry('current_product');
        $id = $product ? (string)$product->getData('maisonproof_record_id') : '';
        return preg_match('/^[A-Za-z0-9_-]{1,80}$/', $id) ? $id : '';
    }
}

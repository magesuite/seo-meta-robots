<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

/** @var \Magento\Framework\Registry $registry */
$registry = $objectManager->get(\Magento\Framework\Registry::class);

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

$productsIds = [555, 556];

foreach ($productsIds as $productId) {
    $product = $objectManager->create(\Magento\Catalog\Model\Product::class);
    $product->load($productId);
    if ($product->getId()) {
        $product->delete();
    }
}

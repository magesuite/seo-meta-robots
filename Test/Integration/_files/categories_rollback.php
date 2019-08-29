<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$registry = $objectManager->get(\Magento\Framework\Registry::class);

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

$categoriesIds = [333, 334];

foreach ($categoriesIds as $categoryId) {
    $category = $objectManager->create(\Magento\Catalog\Model\Category::class);
    $category->load($categoryId);

    if ($category->getId()) {
        $category->delete();
    }
}

<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

/** @var \Magento\Framework\Registry $registry */
$registry = $objectManager->get(\Magento\Framework\Registry::class);

$registry->unregister('isSecureArea');
$registry->register('isSecureArea', true);

/** @var $page \Magento\Cms\Model\Page */
foreach(['page_noindex_nofollow'] as $pageId)  {
    $page = $objectManager->create(\Magento\Cms\Model\Page::class);
    $page->load($pageId);

    if (!$page->getId()) {
        continue;
    }

    $page->delete();
}
<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

/** @var $page \Magento\Cms\Model\Page */
$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setTitle('Page with noindex, nofollow')
    ->setIdentifier('page_noindex_nofollow')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page Design Blank Title1</h1>')
    ->setMetaDescription('Meta description')
    ->setPageLayout('1column')
    ->setMetaRobots(\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW)
    ->save();

/** @var $page \Magento\Cms\Model\Page */
$page = $objectManager->create(\Magento\Cms\Model\Page::class);
$page->setTitle('Page with noindex, follow')
    ->setIdentifier('page_noindex_follow')
    ->setStores([0])
    ->setIsActive(1)
    ->setContent('<h1>Cms Page Design Blank Title1</h1>')
    ->setMetaDescription('Meta description')
    ->setPageLayout('1column')
    ->setMetaRobots(\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW)
    ->save();

<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver\Category;

class DoNotFollowFilteredCategoryTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/categories.php
     * @magentoConfigFixture default/seo/robots_meta_tags/filtered_category_robots 4
     */
    public function testItResolvesCorrectRobotsTagOnFilteredCategoryPageWhenSettingEnabled(): void
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParam('id', 335);
        $this->getRequest()->setParam('price', '10-100');
        $this->dispatch('/catalog/category/view');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="NOINDEX,NOFOLLOW"/>',
            $body
        );
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/categories.php
     * @magentoConfigFixture default_store seo/robots_meta_tags/filtered_category_robots 4
     */
    public function testItResolvesCorrectRobotsTagOnNotFilteredCategoryPageWhenSettingEnabled(): void
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParam('id', 335);
        $this->dispatch('/catalog/category/view');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="INDEX,FOLLOW"/>',
            $body
        );
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/categories.php
     * @magentoConfigFixture default_store seo/robots_meta_tags/filtered_category_robots 0
     */
    public function testItResolvesCorrectRobotsTagOnFilteredCategoryPageWhenSettingDisabled(): void
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParam('id', 335);
        $this->getRequest()->setParam('price', '10-100');
        $this->dispatch('/catalog/category/view');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="INDEX,FOLLOW"/>',
            $body
        );
    }
}

<?php

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver\Category;

class IndexOnlyOnFirstPageOfCategoryTest  extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/categories.php
     * @magentoConfigFixture default_store seo/robots_meta_tags/index_only_on_first_page_of_category 1
     */
    public function testItResolvesCorrectRobotsTagOnSubsequentPaginationPagesWhenSettingEnabled()
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParam('id', 335);
        $this->getRequest()->setParam('p', '2');
        $this->dispatch('/catalog/category/view');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="NOINDEX,FOLLOW"/>',
            $body
        );
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/categories.php
     * @magentoConfigFixture default_store seo/robots_meta_tags/index_only_on_first_page_of_category 0
     */
    public function testItResolvesCorrectRobotsTagOnSubsequentPaginationPagesWhenSettingDisabled()
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParam('id', 335);
        $this->getRequest()->setParam('p', '2');
        $this->dispatch('/catalog/category/view');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="INDEX,FOLLOW"/>',
            $body
        );
    }
}

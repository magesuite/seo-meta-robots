<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver;

class UrlContainsNoIndexParamsTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoConfigFixture default/seo/robots_meta_tags/noindex_url_params noindexParam
     * @magentoDataFixture Magento/Catalog/_files/category.php
     */
    public function testIfReturnsNoindexRobotsTag()
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->getRequest()->setParam('id', 333);
        $this->getRequest()->setParam('noindexParam', 'test');
        $this->dispatch('/catalog/category/view');
        $body = $this->getResponse()->getBody();
        $this->assertStringContainsString(
            '<meta name="robots" content="NOINDEX,NOFOLLOW"/>',
            $body
        );
    }
}

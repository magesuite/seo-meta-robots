<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver;

class NoIndexCustomerSpecificPagesTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testIfReturnsNoindexRobotsTag()
    {
        $this->getRequest()->setMethod(\Magento\Framework\App\Request\Http::METHOD_GET);
        $this->dispatch('/checkout/cart/index');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="NOINDEX,NOFOLLOW"/>',
            $body
        );

        $this->dispatch('/customer/account/login');

        $body = $this->getResponse()->getBody();

        $this->assertStringContainsString(
            '<meta name="robots" content="NOINDEX,NOFOLLOW"/>',
            $body
        );
    }
}

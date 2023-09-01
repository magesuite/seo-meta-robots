<?php

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\Magento\Framework\Registry $registry;

    protected ?\Magento\Catalog\Api\ProductRepositoryInterface $productRepository;

    protected ?\MageSuite\SeoMetaRobots\Model\Resolver\Product $productResolver;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected ?\PHPUnit\Framework\MockObject\MockObject $requestStub;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->registry = $this->objectManager->get(\Magento\Framework\Registry::class);
        $this->productRepository = $this->objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productResolver = $this->objectManager->create(\MageSuite\SeoMetaRobots\Model\Resolver\Product::class, ['request' => $this->requestStub]);
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/products.php
     * @dataProvider productsWithTags
     */
    public function testItResolvesCorrectRobotsTag($sku, $expectedRobotsTag)
    {
        $this->requestStub->method('getFullActionName')->willReturn('catalog_product_view');

        $product = $this->productRepository->get($sku);

        if ($this->registry->registry('current_product')) {
            $this->registry->unregister('current_product');
        }

        $this->registry->register('current_product', $product);

        $this->assertEquals($expectedRobotsTag, $this->productResolver->resolve());
    }

    public static function productsWithTags()
    {
        return [
            ['product_noindex_nofollow', \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW],
            ['product_noindex_follow', \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW],
        ];
    }
}

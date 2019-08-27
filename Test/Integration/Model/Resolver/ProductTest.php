<?php

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver;

class ProductTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \MageSuite\SeoMetaRobots\Model\Resolver\Product
     */
    protected $productResolver;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Magento\Framework\App\Request\Http
     */
    protected $requestStub;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->registry = $this->objectManager->get(\Magento\Framework\Registry::class);
        $this->productRepository = $this->objectManager->get(\Magento\Catalog\Api\ProductRepositoryInterface::class);

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productResolver = $this->objectManager->create(\MageSuite\SeoMetaRobots\Model\Resolver\Product::class, ['request' => $this->requestStub]);
    }

    public static function productsFixture()
    {
        include __DIR__ . '/../../../_files/products.php';
    }

    public static function productsFixtureRollback()
    {
        include __DIR__ . '/../../../_files/products_rollback.php';
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture productsFixture
     */
    public function testItResolvesCorrectRobotsTag()
    {
        $this->requestStub->method('getFullActionName')->willReturn('catalog_product_view');

        $product = $this->productRepository->get('product_noindex_nofollow');

        if ($this->registry->registry('current_product')) {
            $this->registry->unregister('current_product');
        }

        $this->registry->register('current_product', $product);

        $this->assertEquals(\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW, $this->productResolver->resolve());
    }
}
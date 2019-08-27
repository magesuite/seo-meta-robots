<?php

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver;

class CategoryTest extends \PHPUnit\Framework\TestCase
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
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \MageSuite\SeoMetaRobots\Model\Resolver\Category
     */
    protected $categoryResolver;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Magento\Framework\App\Request\Http
     */
    protected $requestStub;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->registry = $this->objectManager->get(\Magento\Framework\Registry::class);
        $this->categoryRepository = $this->objectManager->get(\Magento\Catalog\Api\CategoryRepositoryInterface::class);

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryResolver = $this->objectManager->create(\MageSuite\SeoMetaRobots\Model\Resolver\Category::class, ['request' => $this->requestStub]);

    }

    public static function categoriesFixture()
    {
        include __DIR__ . '/../../../_files/categories.php';
    }

    public static function categoriesFixtureRollback()
    {
        include __DIR__ . '/../../../_files/categories_rollback.php';
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture categoriesFixture
     */
    public function testItResolvesCorrectRobotsTag()
    {
        $this->requestStub->method('getFullActionName')->willReturn('cms_page_view');

        $category = $this->categoryRepository->get(333);

        if ($this->registry->registry('current_category')) {
            $this->registry->unregister('current_category');
        }

        $this->registry->register('current_category', $category);

        $this->assertEquals(\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW, $this->categoryResolver->resolve());
    }
}
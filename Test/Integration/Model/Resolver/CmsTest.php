<?php

namespace Visma\SeoMetaRobots\Test\Integration\Model\Resolver;

class CmsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $requestStub;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageRepository = $this->objectManager->get(\Magento\Cms\Api\PageRepositoryInterface::class);
    }

    public static function pagesFixture()
    {
        include __DIR__ . '/../../_files/pages.php';
    }

    public static function pagesFixtureRollback()
    {
        include __DIR__ . '/../../_files/pages_rollback.php';
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture pagesFixture
     * @dataProvider cmsPagesWithTags
     */
    public function testItResolvesCorrectRobotsTag($pageId, $expectedRobotsTag)
    {
        $this->requestStub->method('getFullActionName')->willReturn('cms_page_view');

        $page = $this->pageRepository->getById($pageId);

        $resolver = $this->objectManager->create(
            \Visma\SeoMetaRobots\Model\Resolver\CmsPage::class,
            ['cmsPage' => $page, 'request' => $this->requestStub]
        );

        $this->assertEquals($expectedRobotsTag, $resolver->resolve());
    }

    public static function cmsPagesWithTags()
    {
        return [
            ['page_noindex_nofollow', \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW],
            ['page_noindex_follow', \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW],
        ];
    }
}

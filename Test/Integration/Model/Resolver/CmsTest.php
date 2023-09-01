<?php

namespace MageSuite\SeoMetaRobots\Test\Integration\Model\Resolver;

class CmsTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    protected ?\Magento\Cms\Api\PageRepositoryInterface $pageRepository;

    protected ?\PHPUnit\Framework\MockObject\MockObject $requestStub;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->pageRepository = $this->objectManager->get(\Magento\Cms\Api\PageRepositoryInterface::class);
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture MageSuite_SeoMetaRobots::Test/Integration/_files/pages.php
     * @dataProvider cmsPagesWithTags
     */
    public function testItResolvesCorrectRobotsTag($pageId, $expectedRobotsTag)
    {
        $this->requestStub->method('getFullActionName')->willReturn('cms_page_view');

        $page = $this->pageRepository->getById($pageId);

        $resolver = $this->objectManager->create(
            \MageSuite\SeoMetaRobots\Model\Resolver\CmsPage::class,
            ['cmsPage' => $page, 'request' => $this->requestStub]
        );

        $this->assertEquals($expectedRobotsTag, $resolver->resolve());
    }

    public static function cmsPagesWithTags()
    {
        return [
            ['page_noindex_nofollow', \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW],
            ['page_noindex_follow', \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW],
        ];
    }
}

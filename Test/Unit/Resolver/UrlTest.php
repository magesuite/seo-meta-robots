<?php

namespace MageSuite\SeoMetaRobots\Test\Unit\Resolver;

class UrlTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;

    /**
     * @var \MageSuite\SeoMetaRobots\Helper\Configuration
     */
    protected ?\PHPUnit\Framework\MockObject\MockObject $configurationStub;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected ?\PHPUnit\Framework\MockObject\MockObject $requestStub;

    protected ?\MageSuite\SeoMetaRobots\Model\Resolver\Url $urlResolver;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->configurationStub = $this->getMockBuilder(\MageSuite\SeoMetaRobots\Helper\Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlResolver = $this->objectManager->create(
            \MageSuite\SeoMetaRobots\Model\Resolver\Url::class,
            ['configuration' => $this->configurationStub, 'request' => $this->requestStub]
        );
    }

    public function testItMatchesUrlsCorrectly()
    {
        $this->configurationStub->method('getUrls')->willReturn([
            ['expression' => 'notmatched', 'tag' => 'NOINDEX_NOFOLLOW'],
            ['expression' => 'matched*', 'tag' => 'INDEX_NOFOLLOW'],
        ]);

        $this->requestStub->method('getRequestUri')->willReturn('/matched.html');

        $result = $this->urlResolver->resolve();

        $this->assertEquals(\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_NOFOLLOW, $result);
    }
}

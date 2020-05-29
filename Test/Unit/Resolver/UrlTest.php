<?php

namespace Visma\SeoMetaRobots\Test\Unit\Resolver;

class UrlTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $configurationStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $requestStub;

    /**
     * @var \Visma\SeoMetaRobots\Model\Resolver\Url
     */
    protected $urlResolver;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->configurationStub = $this->getMockBuilder(\Visma\SeoMetaRobots\Helper\Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlResolver = $this->objectManager->create(
            \Visma\SeoMetaRobots\Model\Resolver\Url::class,
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

        $this->assertEquals(\Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_NOFOLLOW, $result);
    }
}

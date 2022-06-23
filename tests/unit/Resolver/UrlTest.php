<?php

namespace Visma\SeoMetaRobots\Test\Unit\Resolver;

use Magento\Framework\App\Request\Http;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Visma\SeoMetaRobots\Helper\Configuration;
use Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag;
use Visma\SeoMetaRobots\Model\Resolver\Url;
use Visma\SeoMetaRobots\Service\UrlMatcher;

class UrlTest extends TestCase
{
    /**
     * @var ObjectManager
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

    /**
     * @var \Visma\SeoMetaRobots\Service\UrlMatcher
     */
    protected $urlMatcher;

    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->configurationStub = $this->getMockBuilder(Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlMatcher = $this->getMockBuilder(UrlMatcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestStub = $this->getMockBuilder(Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlResolver = $this->objectManager->getObject(
            Url::class,
            [
                'configuration' => $this->configurationStub,
                'request' => $this->requestStub,
                'urlMatcher' => $this->urlMatcher,
            ]
        );
    }

    /**
     * @covers \Visma\SeoMetaRobots\Model\Resolver\Url::resolve
     */
    public function testItMatchesUrlsCorrectly()
    {
        $this->configurationStub->method('getUrlRules')->willReturn([
            ['expression' => 'notmatched', 'tag' => 'NOINDEX_NOFOLLOW'],
            ['expression' => 'matched*', 'tag' => 'INDEX_NOFOLLOW'],
        ]);

        $this->requestStub->method('getRequestUri')->willReturn('/matched.html');
        $this->urlMatcher
            ->expects($this->any())
            ->method('match')
            ->willReturnOnConsecutiveCalls(false, true);

        $result = $this->urlResolver->resolve();

        $this->assertEquals(RobotsMetaTag::INDEX_NOFOLLOW, $result);
    }
}

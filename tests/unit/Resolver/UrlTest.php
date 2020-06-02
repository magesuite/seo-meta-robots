<?php

namespace Visma\SeoMetaRobots\Test\Unit\Resolver;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag;

class UrlTest extends \PHPUnit\Framework\TestCase
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

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->configurationStub = $this->getMockBuilder(\Visma\SeoMetaRobots\Helper\Configuration::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlMatcher = $this->getMockBuilder(\Visma\SeoMetaRobots\Service\UrlMatcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlResolver = $this->objectManager->getObject(
            \Visma\SeoMetaRobots\Model\Resolver\Url::class,
            [
                'configuration' => $this->configurationStub,
                'request' => $this->requestStub,
                'urlMatcher' => $this->urlMatcher,
            ]
        );
    }

    public function testItMatchesUrlsCorrectly()
    {
        $this->configurationStub->method('getUrls')->willReturn([
            ['expression' => 'notmatched', 'tag' => 'NOINDEX_NOFOLLOW'],
            ['expression' => 'matched*', 'tag' => 'INDEX_NOFOLLOW'],
        ]);

        $this->requestStub->method('getRequestUri')->willReturn('/matched.html');
        $this->urlMatcher->expects($this->at(1))->method('match')->willReturn(true);

        $result = $this->urlResolver->resolve();

        $this->assertEquals(RobotsMetaTag::INDEX_NOFOLLOW, $result);
    }
}

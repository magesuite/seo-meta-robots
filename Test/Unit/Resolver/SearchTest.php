<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Test\Unit\Resolver;

class SearchTest extends \PHPUnit\Framework\TestCase
{
    protected ?\MageSuite\SeoMetaRobots\Model\Resolver\Search $searchResolver;
    protected ?\PHPUnit\Framework\MockObject\MockObject $requestStub;

    public function setUp(): void
    {
        $objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->requestStub = $this->getMockBuilder(\Magento\Framework\App\Request\Http::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->searchResolver = $objectManager->create(\MageSuite\SeoMetaRobots\Model\Resolver\Search::class, ['request' => $this->requestStub]);
    }

    /**
     * @dataProvider actionsWithRobots
     */
    public function testItResolvesCorrectRobotsTag(string $fullActionName, ?int $expectedRobotsTag): void
    {
        $this->requestStub->method('getFullActionName')->willReturn($fullActionName);
        $this->assertEquals($expectedRobotsTag, $this->searchResolver->resolve());
    }

    public static function actionsWithRobots(): array
    {
        return [
            ['catalogsearch_result_index', \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW],
            ['cms_page_index', null],
        ];
    }
}

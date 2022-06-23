<?php

namespace Visma\SeoMetaRobots\Test\Unit\Serivce;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Visma\SeoMetaRobots\Service\UrlMatcher;

class UrlMatcherTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Visma\SeoMetaRobots\Service\UrlMatcher
     */
    protected $urlMatcher;

    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->urlMatcher = $this->objectManager->getObject(UrlMatcher::class);
    }

    /**
     * @dataProvider urls
     * @covers \Visma\SeoMetaRobots\Service\UrlMatcher::match
     */
    public function testItMatchesUrls($url, $expression, $expectedResult)
    {
        $result = $this->urlMatcher->match($url, $expression);

        $this->assertEquals($expectedResult, $result);
    }

    public static function urls()
    {
        return [
            ['test/', 'test/*', true],
            ['test/something/else', 'test/*', true],
            ['test1/something/else', 'test/*', false],
            ['test/', 'test/', true],
            ['test/', 'test', false],
            ['test/something/else', 'test/', false],
            ['test.html', 'test*', true],
        ];
    }
}

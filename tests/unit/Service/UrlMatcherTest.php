<?php

namespace Visma\SeoMetaRobots\Test\Unit\Resolver;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class UrlMatcherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Visma\SeoMetaRobots\Service\UrlMatcher
     */
    protected $urlMatcher;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $this->urlMatcher = $this->objectManager->getObject(\Visma\SeoMetaRobots\Service\UrlMatcher::class);
    }

    /**
     * @dataProvider urls
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

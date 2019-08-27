<?php

namespace MageSuite\SeoMetaRobots\Test\Unit\Resolver;

class UrlMatcherTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\SeoMetaRobots\Service\UrlMatcher
     */
    protected $urlMatcher;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->urlMatcher = $this->objectManager->create(\MageSuite\SeoMetaRobots\Service\UrlMatcher::class);
    }

    /**
     * @dataProvider urls
     */
    public function testItMatchesUrls($url, $expression, $expectedResult)
    {
        $result = $this->urlMatcher->match($url, $expression);

        $this->assertEquals($expectedResult, $result);
    }

    public static function urls() {
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

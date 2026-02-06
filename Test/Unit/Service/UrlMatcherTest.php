<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Test\Unit\Resolver;

class UrlMatcherTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;
    protected ?\MageSuite\SeoMetaRobots\Service\UrlMatcher $urlMatcher;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->urlMatcher = $this->objectManager->create(\MageSuite\SeoMetaRobots\Service\UrlMatcher::class);
    }

    /**
     * @dataProvider urls
     */
    public function testItMatchesUrls(string $url, string $expression, bool $expectedResult)
    {
        $result = $this->urlMatcher->match($url, $expression);

        $this->assertEquals($expectedResult, $result);
    }

    public static function urls(): array
    {
        return [
            ['test/', 'test/*', true],
            ['test/something/else', 'test/*', true],
            ['test1/something/else', 'test/*', false],
            ['test/', 'test/', true],
            ['test/', 'test', false],
            ['test/something/else', 'test/', false],
            ['test.html', 'test*', true],
            [str_repeat('test', 5000), 'test*', false],
            [str_repeat('test', 100), 'test*', true],
        ];
    }
}

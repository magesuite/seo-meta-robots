<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Test\Unit\Service;

class RobotsTagGeneratorTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\TestFramework\ObjectManager $objectManager;
    protected ?\MageSuite\SeoMetaRobots\Service\RobotsTagGenerator $robotsTagGenerator;

    /**
     * @var \MageSuite\SeoMetaRobots\Model\ResolversPool
     */
    protected ?\PHPUnit\Framework\MockObject\MockObject $resolversPool;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();

        $this->resolversPool = $this->getMockBuilder(\MageSuite\SeoMetaRobots\Model\ResolversPool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->robotsTagGenerator = $this->objectManager->create(
            \MageSuite\SeoMetaRobots\Service\RobotsTagGenerator::class,
            ['resolversPool' => $this->resolversPool]
        );
    }

    public function testItReturnsValueWhenFirstResolverResolvedIt(): void
    {
        $resolvers = $this->generateResolvers([
            null,
            \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_NOFOLLOW,
            \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW
        ]);

        $this->resolversPool->method('getResolvers')
            ->willReturn($resolvers);

        $this->assertEquals('INDEX,NOFOLLOW', $this->robotsTagGenerator->generate());
    }

    public function testItReturnsIndexFollowWhenNoResolverReturnedValue(): void
    {
        $resolvers = $this->generateResolvers([null, null]);

        $this->resolversPool->method('getResolvers')
            ->willReturn($resolvers);

        $expectedDefaultValue = \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW];
        $this->assertEquals($expectedDefaultValue, $this->robotsTagGenerator->generate());
    }

    protected function generateResolvers($values): array
    {
        $resolvers = [];

        foreach ($values as $value) {
            $resolvers[] = ['resolver' => new class ($value) implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface {
                protected ?int $value;

                public function __construct(?int $value)
                {
                    $this->value = $value;
                }

                public function resolve(): ?int
                {
                    return $this->value;
                }
            }];
        }

        return $resolvers;
    }
}

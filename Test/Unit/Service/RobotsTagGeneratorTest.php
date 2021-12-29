<?php

namespace MageSuite\SeoMetaRobots\Test\Unit\Resolver;

class RobotsTagGeneratorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \MageSuite\SeoMetaRobots\Service\RobotsTagGenerator
     */
    protected $robotsTagGenerator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\MageSuite\SeoMetaRobots\Model\ResolversPool
     */
    protected $resolversPool;

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

    public function testItReturnsValueWhenFirstResolverResolvedIt()
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

    public function testItReturnsIndexFollowWhenNoResolverReturnedValue()
    {
        $resolvers = $this->generateResolvers([null, null]);

        $this->resolversPool->method('getResolvers')
            ->willReturn($resolvers);

        $expectedDefaultValue = \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW];
        $this->assertEquals($expectedDefaultValue, $this->robotsTagGenerator->generate());
    }

    protected function generateResolvers($values)
    {
        $resolvers = [];

        foreach ($values as $value) {
            $resolvers[] = ['resolver' => new class($value) implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface {
                protected $value;
                public function __construct($value)
                {
                    $this->value = $value;
                }
                public function resolve()
                {
                    return $this->value;
                }
            }];
        }

        return $resolvers;
    }
}

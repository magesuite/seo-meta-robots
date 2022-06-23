<?php

namespace Visma\SeoMetaRobots\Test\Unit\Service;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag;
use Visma\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface;
use Visma\SeoMetaRobots\Model\ResolversPool;
use Visma\SeoMetaRobots\Service\RobotsTagGenerator;

class RobotsTagGeneratorTest extends TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Visma\SeoMetaRobots\Service\RobotsTagGenerator
     */
    protected $robotsTagGenerator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Visma\SeoMetaRobots\Model\ResolversPool
     */
    protected $resolversPool;

    public function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->resolversPool = $this->getMockBuilder(ResolversPool::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->robotsTagGenerator = $this->objectManager->getObject(
            RobotsTagGenerator::class,
            ['resolversPool' => $this->resolversPool]
        );
    }

    /**
     * @covers \Visma\SeoMetaRobots\Service\RobotsTagGenerator::generate
     */
    public function testItReturnsValueWhenFirstResolverResolvedIt()
    {
        $resolvers = $this->generateResolvers([null, RobotsMetaTag::INDEX_NOFOLLOW, RobotsMetaTag::NOINDEX_FOLLOW]);

        $this->resolversPool->method('getResolvers')
            ->willReturn($resolvers);

        $this->assertEquals('INDEX,NOFOLLOW', $this->robotsTagGenerator->generate());
    }

    /**
     * @covers \Visma\SeoMetaRobots\Service\RobotsTagGenerator::generate
     */
    public function testItReturnsIndexFollowWhenNoResolverReturnedValue()
    {
        $resolvers = $this->generateResolvers([null, null]);

        $this->resolversPool->method('getResolvers')
            ->willReturn($resolvers);

        $expectedDefaultValue = RobotsMetaTag::$values[RobotsMetaTag::INDEX_FOLLOW];
        $this->assertEquals($expectedDefaultValue, $this->robotsTagGenerator->generate());
    }

    protected function generateResolvers($values)
    {
        $resolvers = [];

        foreach ($values as $value) {
            $resolvers[] = ['resolver' => new class ($value) implements RobotsTagResolverInterface {
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

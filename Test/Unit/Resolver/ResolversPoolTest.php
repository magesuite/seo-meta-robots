<?php

namespace Visma\SeoMetaRobots\Test\Unit\Resolver;

class ResolversPoolTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\TestFramework\ObjectManager
     */
    protected $objectManager;

    public function setUp()
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
    }

    public function testItReturnsEmptyArrayWhenNoResolversWereDefined()
    {
        $resolversPool = new \Visma\SeoMetaRobots\Model\ResolversPool();

        $this->assertEquals([], $resolversPool->getResolvers());
    }

    public function testItReturnsResolversSortedBySortOrder()
    {
        $resolversPool = new \Visma\SeoMetaRobots\Model\ResolversPool(
            [
                ['resolver' => new \stdClass(), 'sort_order' => 30],
                ['resolver' => new \stdClass(), 'sort_order' => 40],
                ['resolver' => new \stdClass(), 'sort_order' => 10],
                ['resolver' => new \stdClass(), 'sort_order' => 20],
            ]
        );

        $resolvers = $resolversPool->getResolvers();

        $this->assertEquals($resolvers[0]['sort_order'], 10);
        $this->assertEquals($resolvers[1]['sort_order'], 20);
        $this->assertEquals($resolvers[2]['sort_order'], 30);
        $this->assertEquals($resolvers[3]['sort_order'], 40);
    }
}

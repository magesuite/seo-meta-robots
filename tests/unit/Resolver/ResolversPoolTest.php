<?php

namespace Visma\SeoMetaRobots\Test\Unit\Resolver;

use PHPUnit\Framework\TestCase;
use stdClass;
use Visma\SeoMetaRobots\Model\ResolversPool;

class ResolversPoolTest extends TestCase
{
    /**
     * @covers \Visma\SeoMetaRobots\Model\ResolversPool::getResolvers
     */
    public function testItReturnsEmptyArrayWhenNoResolversWereDefined()
    {
        $resolversPool = new ResolversPool();

        $this->assertEquals([], $resolversPool->getResolvers());
    }

    /**
     * @covers \Visma\SeoMetaRobots\Model\ResolversPool::getResolvers
     */
    public function testItReturnsResolversSortedBySortOrder()
    {
        $resolversPool = new ResolversPool(
            [
                ['resolver' => new stdClass(), 'sort_order' => 30],
                ['resolver' => new stdClass(), 'sort_order' => 40],
                ['resolver' => new stdClass(), 'sort_order' => 10],
                ['resolver' => new stdClass(), 'sort_order' => 20],
            ]
        );

        $resolvers = $resolversPool->getResolvers();

        $this->assertEquals($resolvers[0]['sort_order'], 10);
        $this->assertEquals($resolvers[1]['sort_order'], 20);
        $this->assertEquals($resolvers[2]['sort_order'], 30);
        $this->assertEquals($resolvers[3]['sort_order'], 40);
    }
}

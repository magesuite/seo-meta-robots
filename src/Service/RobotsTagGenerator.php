<?php

namespace Visma\SeoMetaRobots\Service;

use Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag;
use Visma\SeoMetaRobots\Model\ResolversPool;

class RobotsTagGenerator
{
    /**
     * @var \Visma\SeoMetaRobots\Model\ResolversPool
     */
    protected $resolversPool;

    public function __construct(ResolversPool $resolversPool)
    {
        $this->resolversPool = $resolversPool;
    }

    public function generate()
    {
        $resolvers = $this->resolversPool->getResolvers();
        $values =& RobotsMetaTag::$values;

        foreach ($resolvers as $resolver) {
            /** @var \Visma\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface $resolver */
            $resolver = $resolver['resolver'];

            $resolvedValue = $resolver->resolve();

            if ($resolvedValue != null) {
                return $values[$resolvedValue];
            }
        }

        return $values[RobotsMetaTag::INDEX_FOLLOW];
    }
}

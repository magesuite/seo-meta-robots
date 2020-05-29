<?php

namespace Visma\SeoMetaRobots\Service;

class RobotsTagGenerator
{
    /**
     * @var \Visma\SeoMetaRobots\Model\ResolversPool
     */
    protected $resolversPool;

    public function __construct(\Visma\SeoMetaRobots\Model\ResolversPool $resolversPool)
    {
        $this->resolversPool = $resolversPool;
    }

    public function generate()
    {
        $resolvers = $this->resolversPool->getResolvers();

        foreach ($resolvers as $resolver) {
            /** @var \Visma\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface $resolver */
            $resolver = $resolver['resolver'];

            $resolvedValue = $resolver->resolve();

            if ($resolvedValue != null) {
                return \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[$resolvedValue];
            }
        }

        return \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[\Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW];
    }
}

<?php

namespace MageSuite\SeoMetaRobots\Service;

class RobotsTagGenerator
{
    /**
     * @var \MageSuite\SeoMetaRobots\Model\ResolversPool
     */
    protected $resolversPool;

    public function __construct(\MageSuite\SeoMetaRobots\Model\ResolversPool $resolversPool)
    {
        $this->resolversPool = $resolversPool;
    }

    public function generate() {
        $resolvers = $this->resolversPool->getResolvers();

        foreach($resolvers as $resolver) {
            /** @var \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface $resolver */
            $resolver = $resolver['resolver'];

            $resolvedValue = $resolver->resolve();

            if($resolvedValue != null) {
                return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[$resolvedValue];
            }
        }

        return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW];
    }
}
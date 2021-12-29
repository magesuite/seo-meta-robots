<?php
declare(strict_types=1);

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

    public function generate(): string
    {
        $values = \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values;
        $resolvers = $this->resolversPool->getResolvers();

        foreach ($resolvers as $resolver) {
            /** @var \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface $resolver */
            $resolver = $resolver['resolver'];
            $resolvedValue = $resolver->resolve();

            if ($resolvedValue && isset($values[$resolvedValue])) {
                return $values[$resolvedValue];
            }
        }

        return $values[\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW];
    }
}

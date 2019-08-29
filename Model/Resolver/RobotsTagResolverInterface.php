<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

interface RobotsTagResolverInterface
{
    /**
     * Returns integer value of robots meta tag if resolver is able to determine it
     * Returns null if current resolver is not able to determine meta tag value
     * @return int|null
     */
    public function resolve();
}

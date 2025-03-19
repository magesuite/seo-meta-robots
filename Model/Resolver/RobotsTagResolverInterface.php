<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver;

interface RobotsTagResolverInterface
{
    /**
     * Returns integer value of robots meta tag if resolver is able to determine it
     * Returns null if current resolver is not able to determine meta tag value
     */
    public function resolve(): ?int;
}

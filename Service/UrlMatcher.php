<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Service;

class UrlMatcher
{
    public function match(string $url, string $expression): bool
    {
        return fnmatch($expression, $url);
    }
}

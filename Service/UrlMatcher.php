<?php

namespace MageSuite\SeoMetaRobots\Service;

class UrlMatcher
{
    public function match($url, $expression) {
        return fnmatch($expression, $url);
    }
}
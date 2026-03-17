<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Search implements RobotsTagResolverInterface
{
    protected const ACTION_NAME_PREFIX = 'catalogsearch_';

    public function __construct(
        protected \Magento\Framework\App\Request\Http $request,
    ) {}

    public function resolve(): ?int
    {
        $fullActionName = $this->request->getFullActionName();

        if (!str_starts_with($fullActionName, self::ACTION_NAME_PREFIX)) {
            return null;
        }

        return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW;
    }
}

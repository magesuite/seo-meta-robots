<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver\Category;

class IndexOnlyOnFirstPageOfCategory implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    const CATEGORY_VIEW_FULL_ACTION_NAME = 'catalog_category_view';
    const PAGINATION_PARAM = 'p';

    protected \Magento\Framework\App\Request\Http $request;

    protected \Magento\Framework\Registry $registry;

    protected \MageSuite\SeoMetaRobots\Helper\Configuration $configuration;

    protected \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        \MageSuite\SeoMetaRobots\Helper\Configuration $configuration,
        \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
    ) {
        $this->request = $request;
        $this->registry = $registry;
        $this->configuration = $configuration;
        $this->metaRobotsTagHelper = $metaRobotsTagHelper;
    }

    /**
     * @inheritDoc
     */
    public function resolve()
    {
        if (!$this->configuration->isIndexOnCategoryFirstPageEnabled()) {
            return null;
        }
        $fullActionName = $this->request->getFullActionName();

        if ($fullActionName != self::CATEGORY_VIEW_FULL_ACTION_NAME) {
            return null;
        }

        $category = $this->registry->registry('current_category');

        if ($category == null) {
            return null;
        }

        $params = $this->request->getParams();

        $metaRobots = $category->getMetaRobots();

        if (!$this->isFirstPaginationPage($params)) {
            return $this->getMetaRobotsTagForSubsequentPages($metaRobots);
        }

        return $metaRobots;
    }

    public function isFirstPaginationPage($params): bool
    {
        return !isset($params[self::PAGINATION_PARAM]) || ($params[self::PAGINATION_PARAM] == 1);
    }

    public function getMetaRobotsTagForSubsequentPages($metaRobots): ?string
    {
        if (empty($metaRobots)) {
            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW;
        }

        $followOption = $this->metaRobotsTagHelper->getFollowOption($metaRobots);

        if (empty($followOption)) {
            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW;
        }

        $newMetaRobotsTagString = sprintf('NOINDEX_%s', $followOption);

        return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$tags[$newMetaRobotsTagString] ?? null;
    }
}

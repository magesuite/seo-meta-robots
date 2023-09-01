<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver\Category;

class IndexOnlyOnFirstPageOfCategory implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    const CATEGORY_VIEW_FULL_ACTION_NAME = 'catalog_category_view';
    const PAGINATION_PARAM = 'p';

    protected \Magento\Framework\App\Request\Http $request;

    protected \Magento\Framework\Registry $registry;

    protected \MageSuite\SeoMetaRobots\Helper\Configuration $configuration;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        \MageSuite\SeoMetaRobots\Helper\Configuration $configuration
    ) {
        $this->request = $request;
        $this->registry = $registry;
        $this->configuration = $configuration;
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

        if (isset($params[self::PAGINATION_PARAM]) && $params[self::PAGINATION_PARAM] != 1) {
            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW;
        }

        return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW;
    }
}

<?php

namespace Visma\SeoMetaRobots\Model\Resolver\Category;

class IndexOnlyOnFirstPageOfCategory implements \Visma\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    public const CATEGORY_VIEW_FULL_ACTION_NAME = 'catalog_category_view';
    public const PAGINATION_PARAM = 'p';
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;
    /**
     * @var \Visma\SeoMetaRobots\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        \Visma\SeoMetaRobots\Helper\Configuration $configuration
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
            return \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW;
        }

        return \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::INDEX_FOLLOW;
    }
}

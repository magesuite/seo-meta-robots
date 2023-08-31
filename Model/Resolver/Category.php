<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Category implements RobotsTagResolverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry
    ) {
        $this->request = $request;
        $this->registry = $registry;
    }

    /**
     * @inheritDoc
     */
    public function resolve()
    {
        $fullActionName = $this->request->getFullActionName();
        $category = $this->registry->registry('current_category');

        if ($fullActionName != 'catalog_category_view'
            || !$category instanceof \Magento\Catalog\Model\Category) {
            return null;
        }

        $metaRobots = $category->getMetaRobots();

        if (empty($metaRobots)) {
            return null;
        }

        return $metaRobots;
    }
}

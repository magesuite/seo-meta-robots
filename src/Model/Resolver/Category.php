<?php

namespace Visma\SeoMetaRobots\Model\Resolver;

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

        if ($fullActionName != 'catalog_category_view') {
            return null;
        }

        $category = $this->registry->registry('current_category');

        if ($category == null) {
            return null;
        }

        $metaRobots = $category->getMetaRobots();

        if ($metaRobots == null) {
            return null;
        }

        return $metaRobots;
    }
}

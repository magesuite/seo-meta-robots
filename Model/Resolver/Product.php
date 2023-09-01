<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Product implements RobotsTagResolverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected \Magento\Framework\Registry $registry;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry
    ) {
        $this->request = $request;
        $this->registry = $registry;
    }

    public function resolve()
    {
        $fullActionName = $this->request->getFullActionName();

        if ($fullActionName != 'catalog_product_view') {
            return null;
        }

        $product = $this->registry->registry('current_product');

        if ($product == null) {
            return null;
        }

        $metaRobots = $product->getMetaRobots();

        if ($metaRobots == null) {
            return null;
        }

        return $metaRobots;
    }
}

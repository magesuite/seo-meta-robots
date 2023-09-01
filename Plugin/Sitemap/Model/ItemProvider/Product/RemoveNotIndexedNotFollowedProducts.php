<?php

namespace MageSuite\SeoMetaRobots\Plugin\Sitemap\Model\ItemProvider\Product;

class RemoveNotIndexedNotFollowedProducts
{

    protected \MageSuite\SeoMetaRobots\Model\ResourceModel\Product\Collection $productCollecction;

    protected \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper;

    public function __construct(
        \MageSuite\SeoMetaRobots\Model\ResourceModel\Product\Collection $productCollecction,
        \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
    ) {
        $this->productCollecction = $productCollecction;
        $this->metaRobotsTagHelper = $metaRobotsTagHelper;
    }

    public function afterGetItems(\Magento\Sitemap\Model\ItemProvider\Product $product, $result, int $storeId)
    {
        $productsIds = array_keys($result);
        $productsMetaRobotsAttributes = $this->productCollecction->getProductsMetaRobotsAttributes($productsIds, $storeId);

        foreach ($result as $productId => $productData) {
            if (!isset($productsMetaRobotsAttributes[$productId]['meta_robots_option'])) {
                continue;
            }

            if ($this->metaRobotsTagHelper->isNoIndexOption((int) $productsMetaRobotsAttributes[$productId]['meta_robots_option'])) {
                unset($result[$productId]);
            }
        }

        return $result;
    }
}

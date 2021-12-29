<?php

namespace MageSuite\SeoMetaRobots\Plugin\Sitemap\Model\ItemProvider\Category;

class RemoveNotIndexedNotFollowedCategories
{
    /**
     * @var \MageSuite\SeoMetaRobots\Model\ResourceModel\Category\Collection
     */
    protected $categoryCollection;

    /**
     * @var \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag
     */
    protected $metaRobotsTagHelper;

    /**
     * @param \MageSuite\SeoMetaRobots\Model\ResourceModel\Category\Collection $categoryCollection
     * @param \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
     */
    public function __construct(
        \MageSuite\SeoMetaRobots\Model\ResourceModel\Category\Collection $categoryCollection,
        \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
    ) {
        $this->categoryCollection = $categoryCollection;
        $this->metaRobotsTagHelper = $metaRobotsTagHelper;
    }

    /**
     * @param \Magento\Sitemap\Model\ItemProvider\Category $category
     * @param $result
     * @param int $storeId
     * @return mixed
     * @throws \Zend_Db_Statement_Exception
     */
    public function afterGetItems(\Magento\Sitemap\Model\ItemProvider\Category $category, $result, int $storeId)
    {
        $categoriesIds = array_keys($result);
        $categoriesMetaRobotsAttributes = $this->categoryCollection->getCategoriesMetaRobotsAttributes($categoriesIds, $storeId);

        foreach ($result as $categoryId => $categoryData) {
            if (!isset($categoriesMetaRobotsAttributes[$categoryId]['meta_robots_option'])) {
                continue;
            }

            if ($this->metaRobotsTagHelper->isNoIndexOption((int)$categoriesMetaRobotsAttributes[$categoryId]['meta_robots_option'])) {
                unset($result[$categoryId]);
            }
        }

        return $result;
    }
}

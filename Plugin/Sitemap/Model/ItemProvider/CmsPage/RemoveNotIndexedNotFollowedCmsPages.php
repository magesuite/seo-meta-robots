<?php

namespace MageSuite\SeoMetaRobots\Plugin\Sitemap\Model\ItemProvider\CmsPage;

class RemoveNotIndexedNotFollowedCmsPages
{
    /**
     * @var \MageSuite\SeoMetaRobots\Model\ResourceModel\CmsPage\Collection
     */
    protected $cmsPageCollection;

    /**
     * @var \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag
     */
    protected $metaRobotsTagHelper;

    /**
     * @param \MageSuite\SeoMetaRobots\Model\ResourceModel\CmsPage\Collection $cmsPageCollection
     * @param \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
     */
    public function __construct(
        \MageSuite\SeoMetaRobots\Model\ResourceModel\CmsPage\Collection $cmsPageCollection,
        \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
    )
    {
        $this->cmsPageCollection = $cmsPageCollection;
        $this->metaRobotsTagHelper = $metaRobotsTagHelper;
    }

    /**
     * @param \Magento\Sitemap\Model\ItemProvider\CmsPage $cmsPage
     * @param $result
     * @return mixed
     * @throws \Zend_Db_Statement_Exception
     */
    public function afterGetItems(\Magento\Sitemap\Model\ItemProvider\CmsPage $cmsPage, $result)
    {
        $pagesIds = array_keys($result);
        $cmsPagesMetaRobotsAttributes = $this->cmsPageCollection->getCmsPagesMetaRobotsAttributes($pagesIds);

        foreach ($result as $pageId => $cmsPageData) {
            if (isset($cmsPagesMetaRobotsAttributes[$pageId]['meta_robots_option'])
                && $this->metaRobotsTagHelper->isNoIndexOption((int) $cmsPagesMetaRobotsAttributes[$pageId]['meta_robots_option'])) {
                unset($result[$pageId]);
            }
        }

        return $result;
    }


}

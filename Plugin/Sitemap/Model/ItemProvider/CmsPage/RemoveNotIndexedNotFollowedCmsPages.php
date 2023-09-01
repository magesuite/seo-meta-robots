<?php

namespace MageSuite\SeoMetaRobots\Plugin\Sitemap\Model\ItemProvider\CmsPage;

class RemoveNotIndexedNotFollowedCmsPages
{
    protected \MageSuite\SeoMetaRobots\Model\ResourceModel\CmsPage\Collection $cmsPageCollection;

    protected \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper;

    public function __construct(
        \MageSuite\SeoMetaRobots\Model\ResourceModel\CmsPage\Collection $cmsPageCollection,
        \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper
    ) {
        $this->cmsPageCollection = $cmsPageCollection;
        $this->metaRobotsTagHelper = $metaRobotsTagHelper;
    }

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

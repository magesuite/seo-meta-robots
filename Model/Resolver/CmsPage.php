<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class CmsPage implements RobotsTagResolverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected \Magento\Cms\Model\Page $cmsPage;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Cms\Model\Page $cmsPage
    ) {
        $this->request = $request;
        $this->cmsPage = $cmsPage;
    }

    public function resolve()
    {
        $fullActionName = $this->request->getFullActionName();

        $allowedActions = ['cms_noroute_index', 'cms_index_index', 'cms_page_view'];
        
        if (!in_array($fullActionName, $allowedActions)) {
            return null;
        }

        $cmsPage = $this->cmsPage;

        if ($cmsPage->getMetaRobots() == null) {
            return null;
        }

        return $cmsPage->getMetaRobots();
    }
}

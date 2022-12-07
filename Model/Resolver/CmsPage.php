<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class CmsPage implements RobotsTagResolverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $cmsPage;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Cms\Model\Page $cmsPage
    ) {
        $this->request = $request;
        $this->cmsPage = $cmsPage;
    }

    /**
     * @inheritDoc
     */
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

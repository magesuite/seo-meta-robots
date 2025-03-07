<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class CmsPage implements RobotsTagResolverInterface
{
    public const CMS_ACTION_NAMES = ['cms_index_index', 'cms_page_view', 'cms_noroute_index'];

    protected \Magento\Framework\App\Request\Http $request;
    protected \Magento\Cms\Model\Page $cmsPage;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Cms\Model\Page $cmsPage
    ) {
        $this->request = $request;
        $this->cmsPage = $cmsPage;
    }

    public function resolve(): ?int
    {
        $fullActionName = $this->request->getFullActionName();

        if (!in_array($fullActionName, self::CMS_ACTION_NAMES)) {
            return null;
        }

        $cmsPage = $this->cmsPage;

        if ($cmsPage->getMetaRobots() == null) {
            return null;
        }

        return (int)$cmsPage->getMetaRobots();
    }
}

<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class NoIndexCustomerSpecificPages implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    const NON_INDEXABLE_MODULES = [
        'customer',
        'checkout'
    ];

    protected \Magento\Framework\App\Request\Http $request;

    protected \MageSuite\SeoMetaRobots\Service\UrlMatcher $urlMatcher;

    protected \MageSuite\SeoMetaRobots\Helper\Configuration $configuration;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \MageSuite\SeoMetaRobots\Service\UrlMatcher $urlMatcher,
        \MageSuite\SeoMetaRobots\Helper\Configuration $configuration
    ) {
        $this->request = $request;
        $this->urlMatcher = $urlMatcher;
        $this->configuration = $configuration;
    }

    public function resolve(): ?int
    {
        if (!$this->configuration->isNoIndexForCustomerSpecificPagesEnabled()) {
            return null;
        }

        $controllerModule = $this->request->getModuleName();

        if (in_array($controllerModule, self::NON_INDEXABLE_MODULES)) {
            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW;
        }

        return null;
    }
}

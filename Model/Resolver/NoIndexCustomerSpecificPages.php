<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class NoIndexCustomerSpecificPages implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected \MageSuite\SeoMetaRobots\Service\UrlMatcher $urlMatcher;

    protected \MageSuite\SeoMetaRobots\Helper\Configuration $configuration;

    protected array $modules = [];

    protected array $controllers = [];

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \MageSuite\SeoMetaRobots\Service\UrlMatcher $urlMatcher,
        \MageSuite\SeoMetaRobots\Helper\Configuration $configuration,
        array $modules = [],
        array $controllers = []
    ) {
        $this->request = $request;
        $this->urlMatcher = $urlMatcher;
        $this->configuration = $configuration;

        $this->modules = $modules;
        $this->controllers = $controllers;
    }

    public function resolve(): ?int
    {
        if (!$this->configuration->isNoIndexForCustomerSpecificPagesEnabled()) {
            return null;
        }

        $controllerModule = $this->request->getModuleName();

        if (in_array($controllerModule, $this->modules)) {
            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW;
        }

        $controller = sprintf('%s_%s', $this->request->getModuleName(), $this->request->getControllerName());

        if (in_array($controller, array_keys($this->controllers))) {
            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW;
        }

        return null;
    }
}

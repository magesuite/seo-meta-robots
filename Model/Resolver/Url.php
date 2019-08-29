<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Url implements RobotsTagResolverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \MageSuite\SeoMetaRobots\Service\UrlMatcher
     */
    protected $urlMatcher;

    /**
     * @var \MageSuite\SeoMetaRobots\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \MageSuite\SeoMetaRobots\Service\UrlMatcher $urlMatcher,
        \MageSuite\SeoMetaRobots\Helper\Configuration $configuration
    ) {
        $this->request = $request;
        $this->urlMatcher = $urlMatcher;
        $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function resolve()
    {
        $urls = $this->configuration->getUrls();

        if (empty($urls)) {
            return null;
        }

        $uri = ltrim($this->request->getRequestUri(), '/');

        foreach ($urls as $url) {
            if ($this->urlMatcher->match($uri, $url['expression'])) {
                return $this->tagToReturnValue($url['tag']);
            }
        }

        return null;
    }

    protected function tagToReturnValue($tag)
    {
        $tag = strtoupper($tag);

        if (!isset(\MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$tags[$tag])) {
            return null;
        }

        return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$tags[$tag];
    }
}

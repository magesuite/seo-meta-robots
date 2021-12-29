<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class UrlContainsNoIndexParams implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \MageSuite\SeoMetaRobots\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \MageSuite\SeoMetaRobots\Helper\Configuration $configuration
    ) {
        $this->request = $request;
        $this->configuration = $configuration;
    }

    public function resolve(): ?int
    {
        if (!$this->request->isGet()) {
            return null;
        }

        $noindexParams = $this->configuration->getNoindexUrlParams();

        foreach ($noindexParams as $noindexParam) {
            if ($this->request->getParam($noindexParam) === null) {
                continue;
            }

            return \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW;
        }

        return null;
    }
}

<?php

namespace MageSuite\SeoMetaRobots\Helper;

class Configuration
{
    const URLS_XML_PATH = 'seo/robots_meta_tags/urls';

    const LINES_DELIMITER = PHP_EOL;
    const COLUMNS_DELIMITER = ';';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getUrls() {
        $urls = $this->scopeConfig->getValue(self::URLS_XML_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if(empty($urls)) {
            return [];
        }

        $urls = explode(self::LINES_DELIMITER, $urls);

        $return = [];

        foreach($urls as $url) {
            $url = explode(self::COLUMNS_DELIMITER, $url);

            $return[] = ['expression' => $url[0], 'tag' => $url[1]];
        }

        return $return;
    }
}
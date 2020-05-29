<?php

namespace Visma\SeoMetaRobots\Helper;

class Configuration
{
    const URLS_XML_PATH = 'visma_seo_meta_robots/robots_meta_tags/urls';
    const INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY_PATH = 'visma_seo_meta_robots/robots_meta_tags/index_only_on_first_page_of_category';

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

    public function getUrls()
    {
        $urls = $this->scopeConfig->getValue(self::URLS_XML_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if (empty($urls)) {
            return [];
        }

        $urls = explode(self::LINES_DELIMITER, $this->cleanUrlsList($urls));

        $return = [];

        foreach ($urls as $url) {
            $url = explode(self::COLUMNS_DELIMITER, $url);

            try {
                $return[] = ['expression' => $url[0], 'tag' => $url[1]];
            }
            catch (\Exception $exception) {
                //Do nothing.
            }
        }

        return $return;
    }

    protected function cleanUrlsList($urlsList)
    {
        $urlsList = str_replace("\r\n", "\n", $urlsList);
        $urlsList = str_replace("\r", "\n", $urlsList);

        return $urlsList;
    }

    public function isIndexOnCategoryFirstPageEnabled()
    {
        return $this->scopeConfig->getValue(
            self::INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}

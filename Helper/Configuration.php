<?php

namespace MageSuite\SeoMetaRobots\Helper;

class Configuration
{
    const URLS_XML_PATH = 'seo/robots_meta_tags/urls';
    const INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY_PATH = 'seo/robots_meta_tags/index_only_on_first_page_of_category';
    const XML_PATH_NOINDEX_URL_PARAMS = 'seo/robots_meta_tags/noindex_url_params';
    const XML_PATH_NOINDEX_CUSTOMER_SPECIFIC_PAGES = 'seo/robots_meta_tags/noindex_customer_specific_pages';

    const LINES_DELIMITER = PHP_EOL;
    const COLUMNS_DELIMITER = ';';

    protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getUrls(): array
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
                // phpcs:ignore Magento2.CodeAnalysis.EmptyBlock
            } catch (\Exception $exception) {
                //Do nothing.
            }
        }

        return $return;
    }

    protected function cleanUrlsList($urlsList): ?string
    {
        $urlsList = str_replace("\r\n", "\n", $urlsList);
        $urlsList = str_replace("\r", "\n", $urlsList);

        return $urlsList;
    }

    public function isIndexOnCategoryFirstPageEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function isNoIndexForCustomerSpecificPagesEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_NOINDEX_CUSTOMER_SPECIFIC_PAGES, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getNoindexUrlParams(): array
    {
        $value = (string)$this->scopeConfig->getValue(self::XML_PATH_NOINDEX_URL_PARAMS);

        if (empty($value)) {
            return [];
        }

        return explode(',', $value);
    }
}

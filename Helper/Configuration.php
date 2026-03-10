<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Helper;

class Configuration
{
    protected const XML_PATH_ROBOTS_META_TAGS_URLS = 'seo/robots_meta_tags/urls';
    protected const XML_PATH_ROBOTS_META_TAGS_INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY = 'seo/robots_meta_tags/index_only_on_first_page_of_category';
    protected const XML_PATH_ROBOTS_META_TAGS_FILTERED_CATEGORY_ROBOTS = 'seo/robots_meta_tags/filtered_category_robots';
    protected const XML_PATH_ROBOTS_META_TAGS_NOINDEX_URL_PARAMS = 'seo/robots_meta_tags/noindex_url_params';
    protected const XML_PATH_ROBOTS_META_TAGS_NOINDEX_CUSTOMER_SPECIFIC_PAGES = 'seo/robots_meta_tags/noindex_customer_specific_pages';

    protected const LINES_DELIMITER = PHP_EOL;
    protected const COLUMNS_DELIMITER = ';';

    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
    }

    public function getUrls(): array
    {
        $urls = $this->scopeConfig->getValue(self::XML_PATH_ROBOTS_META_TAGS_URLS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

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
            }
        }

        return $return;
    }

    public function isIndexOnCategoryFirstPageEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ROBOTS_META_TAGS_INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getFilteredCategoryRobots(): int
    {
        return (int) $this->scopeConfig->getValue(self::XML_PATH_ROBOTS_META_TAGS_FILTERED_CATEGORY_ROBOTS);
    }

    public function isNoIndexForCustomerSpecificPagesEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ROBOTS_META_TAGS_NOINDEX_CUSTOMER_SPECIFIC_PAGES, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getNoindexUrlParams(): array
    {
        $value = (string)$this->scopeConfig->getValue(self::XML_PATH_ROBOTS_META_TAGS_NOINDEX_URL_PARAMS);

        if (empty($value)) {
            return [];
        }

        return explode(',', $value);
    }

    protected function cleanUrlsList(string $urlsList): string
    {
        $urlsList = str_replace("\r\n", "\n", $urlsList);

        return str_replace("\r", "\n", $urlsList);
    }
}

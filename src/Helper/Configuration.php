<?php

namespace Visma\SeoMetaRobots\Helper;

class Configuration
{
    public const ROBOTS_URL_RULES_PATH = 'catalog/seo/robots_url_rules';
    public const ROBOTS_INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY_PATH =
        'catalog/seo/robots_index_only_on_first_page_of_category';

    public const LINES_DELIMITER = PHP_EOL;
    public const COLUMNS_DELIMITER = ';';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getUrlRules()
    {
        $rules = $this->scopeConfig->getValue(
            self::ROBOTS_URL_RULES_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        if (empty($rules)) {
            return [];
        }

        $rules = explode(self::LINES_DELIMITER, $this->cleanUrlsList($rules));

        $return = [];

        foreach ($rules as $rule) {
            $rule = explode(self::COLUMNS_DELIMITER, $rule);

            try {
                $return[] = ['expression' => $rule[0], 'tag' => $rule[1]];
            // phpcs:ignore
            } catch (\Exception $exception) {
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
            self::ROBOTS_INDEX_ONLY_ON_FIRST_PAGE_OF_CATEGORY_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}

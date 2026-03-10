<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Setup\Patch\Data;

class MigrateFilteredCategoryRobots implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    protected const OLD_PATH = 'seo/robots_meta_tags/noindex_nofollow_for_filtered_category';
    protected const NEW_PATH = 'seo/robots_meta_tags/filtered_category_robots';

    protected const OLD_YES = '1';
    protected const NEW_VALUE = \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW;

    public function __construct(
        protected \Magento\Framework\App\ResourceConnection $resource
    ) {
    }

    public function apply() //phpcs:ignore
    {
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('core_config_data');

        $rows = $connection->fetchAll(
            $connection->select()
                ->from($table)
                ->where('path = ?', self::OLD_PATH)
        );

        foreach ($rows as $row) {

            if ($row['value'] !== self::OLD_YES) {
                continue;
            }

            $connection->insertOnDuplicate(
                $table,
                [
                    'scope' => $row['scope'],
                    'scope_id' => $row['scope_id'],
                    'path' => self::NEW_PATH,
                    'value' => self::NEW_VALUE
                ],
                ['value']
            );
        }
    }

    public static function getDependencies() //phpcs:ignore
    {
        return [];
    }

    public function getAliases() //phpcs:ignore
    {
        return [];
    }
}

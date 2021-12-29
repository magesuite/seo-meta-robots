<?php

namespace MageSuite\SeoMetaRobots\Model\ResourceModel\Category;

class Collection
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @var \Magento\Framework\EntityManager\MetadataPool
     */
    protected $metadataPool;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Framework\EntityManager\MetadataPool $metadataPool
    ) {
        $this->resource = $resource;
        $this->metadataPool = $metadataPool;
    }

    /**
     * @param array $categoriesIds
     * @param int $storeId
     * @return array
     * @throws \Zend_Db_Statement_Exception
     */
    public function getCategoriesMetaRobotsAttributes(array $categoriesIds, int $storeId): array
    {
        $linkField = $this->metadataPool->getMetadata(\Magento\Catalog\Api\Data\CategoryInterface::class)->getLinkField();
        /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $connection */
        $connection = $this->resource->getConnection();
        $subSelect = $connection->select()->from(
            ['eav_attribute' => $this->resource->getTableName('eav_attribute')],
            []
        )->join(
            ['catalog_category_entity_int' => $this->resource->getTableName('catalog_category_entity_int')],
            'eav_attribute.attribute_id = catalog_category_entity_int.attribute_id'
            . $connection->quoteInto(' AND catalog_category_entity_int.store_id IN (0, ?)', $storeId),
            [
                'store_id' => 'MAX(store_id)',
                'attribute_id' => 'attribute_id',
                'row_id' => $linkField
            ]
        )->join(
            ['catalog_category_entity' => $this->resource->getTableName('catalog_category_entity')],
            sprintf('catalog_category_entity_int.%1$s = catalog_category_entity.%1$s', $linkField),
            [
                'category_id' => 'entity_id'
            ]
        )->where(
            'eav_attribute.entity_type_id = ?',
            \Magento\Catalog\Setup\CategorySetup::CATEGORY_ENTITY_TYPE_ID
        )->where(
            'eav_attribute.attribute_code = ?',
            \MageSuite\SeoMetaRobots\Setup\UpgradeData::ATTRIBUTE_CODE
        )->where(
            ' catalog_category_entity.entity_id IN (?)',
            $categoriesIds
        )->group(
            'catalog_category_entity.entity_id'
        );

        $categoriesMetaRobotsAttributeSelect = $connection->select()->from(
            ['catalog_category_entity_int' => $this->resource->getTableName('catalog_category_entity_int')],
            [
                'meta_robots_option' => 'value'
            ]
        )->join(
            ['t1' => $subSelect],
            sprintf('catalog_category_entity_int.%s = t1.row_id', $linkField)
            . ' AND catalog_category_entity_int.attribute_id = t1.attribute_id'
            . ' AND catalog_category_entity_int.store_id = t1.store_id',
            [
                'category_id' => 'category_id'
            ]
        );

        $result = $connection
            ->query($categoriesMetaRobotsAttributeSelect)
            ->fetchAll();

        $categoriesMetaRobotsAttributes = $this->convertResult($result);

        return $categoriesMetaRobotsAttributes;
    }

    /**
     * @param array|null $result
     * @return array
     */
    private function convertResult(?array $result): array
    {
        if (!$result) {
            return [];
        }

        $categoriesMetaRobotsAttributes = [];
        foreach ($result as $categoryAttribute) {
            $categoriesMetaRobotsAttributes[$categoryAttribute['category_id']]['meta_robots_option'] = $categoryAttribute['meta_robots_option'];
        }

        return $categoriesMetaRobotsAttributes;
    }
}

<?php

namespace MageSuite\SeoMetaRobots\Model\ResourceModel\Product;

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
     * @param array $productsIds
     * @param int $storeId
     * @return array
     * @throws \Zend_Db_Statement_Exception
     */
    public function getProductsMetaRobotsAttributes(array $productsIds, int $storeId): array
    {
        $linkField = $this->metadataPool->getMetadata(\Magento\Catalog\Api\Data\ProductInterface::class)->getLinkField();
        /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $connection */
        $connection = $this->resource->getConnection();
        $subSelect = $connection->select()->from(
            ['eav_attribute' => $this->resource->getTableName('eav_attribute')],
            []
        )->join(
            ['catalog_product_entity_int' => $this->resource->getTableName('catalog_product_entity_int')],
            'eav_attribute.attribute_id = catalog_product_entity_int.attribute_id'
            . $connection->quoteInto(' AND catalog_product_entity_int.store_id IN (0, ?)', $storeId),
            [
                'store_id' => 'MAX(store_id)',
                'attribute_id' => 'attribute_id',
                'row_id' => $linkField
            ]
        )->join(
            ['catalog_product_entity' => $this->resource->getTableName('catalog_product_entity')],
            sprintf('catalog_product_entity_int.%1$s = catalog_product_entity.%1$s', $linkField),
            [
                'product_id' => 'entity_id'
            ]
        )->where(
            'eav_attribute.entity_type_id = ?',
            \Magento\Catalog\Setup\CategorySetup::CATALOG_PRODUCT_ENTITY_TYPE_ID
        )->where(
            'eav_attribute.attribute_code = ?',
            \MageSuite\SeoMetaRobots\Setup\UpgradeData::ATTRIBUTE_CODE
        )->where(
            ' catalog_product_entity.entity_id IN (?)',
            $productsIds
        )->group(
            'catalog_product_entity.entity_id'
        );

        $productsMetaRobotsAttributeSelect = $connection->select()->from(
            ['catalog_product_entity_int' => $this->resource->getTableName('catalog_product_entity_int')],
            [
                'meta_robots_option' => 'value'
            ]
        )->join(
            ['t1' => $subSelect],
            sprintf('catalog_product_entity_int.%s = t1.row_id', $linkField)
            . ' AND catalog_product_entity_int.attribute_id = t1.attribute_id'
            . ' AND catalog_product_entity_int.store_id = t1.store_id',
            [
                'product_id' => 'product_id'
            ]
        );

        $result = $connection
            ->query($productsMetaRobotsAttributeSelect)
            ->fetchAll();

        $productsMetaRobotsAttributes = $this->convertResult($result);

        return $productsMetaRobotsAttributes;
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

        $productsMetaRobotsAttributes = [];
        foreach ($result as $productAttribute) {
            $productsMetaRobotsAttributes[$productAttribute['product_id']]['meta_robots_option'] = $productAttribute['meta_robots_option'];
        }

        return $productsMetaRobotsAttributes;
    }
}

<?php

namespace MageSuite\SeoMetaRobots\Model\ResourceModel\CmsPage;

class Collection
{
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resource
     */
    public function __construct(
        \Magento\Framework\App\ResourceConnection $resource
    )
    {
        $this->resource = $resource;
    }

    /**
     * @param array $productsIds
     * @return array
     * @throws \Zend_Db_Statement_Exception
     */
    public function getCmsPagesMetaRobotsAttributes(array $pagesIds): array
    {
        /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $connection */
        $connection = $this->resource->getConnection();
        $cmsPagesMetaRobotsAttributeSelect = $connection->select()->from(
            ['cms_page' => $this->resource->getTableName('cms_page')],
            [
                'page_id' => 'page_id',
                'meta_robots_option' => 'meta_robots'
            ]
        )->where(
            ' cms_page.page_id IN (?)', $pagesIds
        );

        $result = $connection
            ->query($cmsPagesMetaRobotsAttributeSelect)
            ->fetchAll();

        $cmsPagesMetaRobotsAttributes = $this->convertResult($result);

        return $cmsPagesMetaRobotsAttributes;
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

        $cmsPagesMetaRobotsAttributes = [];
        foreach ($result as $pageAttribute) {
            $cmsPagesMetaRobotsAttributes[$pageAttribute['page_id']]['meta_robots_option'] = $pageAttribute['meta_robots_option'];
        }

        return $cmsPagesMetaRobotsAttributes;
    }
}

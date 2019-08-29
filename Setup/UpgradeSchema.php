<?php

namespace MageSuite\SeoMetaRobots\Setup;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    const COLUMN_NAME = 'meta_robots';

    public function upgrade(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $setup->startSetup();

        $cmsPageTable = $setup->getTable('cms_page');

        if (version_compare($context->getVersion(), '1.0.1', '<') &&
            !$setup->getConnection()->tableColumnExists($cmsPageTable, self::COLUMN_NAME)
        ) {
            $setup->getConnection()->addColumn(
                $cmsPageTable,
                self::COLUMN_NAME,
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'comment' => 'Meta robots tag contents'
                ]
            );
        }

        $setup->endSetup();
    }
}

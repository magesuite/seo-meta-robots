<?php

namespace MageSuite\SeoMetaRobots\Setup;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public function upgrade(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $setup->startSetup();

        $cmsPageTable = $setup->getTable('cms_page');

        if (
            version_compare($context->getVersion(), '1.0.1', '<') and
            !$setup->getConnection()->tableColumnExists($cmsPageTable, 'meta_robots')
        ) {
            $setup->getConnection()->changeColumn(
                $cmsPageTable,
                'meta_robots',
                'meta_robots',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'comment' => 'Meta robots tag contents'
                ]
            );
        }

        $setup->endSetup();
    }
}
<?php

namespace Visma\SeoMetaRobots\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    public const COLUMN_NAME = 'meta_robots';

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $cmsPageTable = $setup->getTable('cms_page');
        //phpcs:ignore
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

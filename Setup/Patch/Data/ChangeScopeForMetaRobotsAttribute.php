<?php

namespace MageSuite\SeoMetaRobots\Setup\Patch\Data;

class ChangeScopeForMetaRobotsAttribute implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    protected \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup;

    protected \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory;

    public function __construct(
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        //Update product 'meta_robots' attribute
        $productEntityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $productMetaRobotsAttribute = $eavSetup->getAttribute($productEntityTypeId, \MageSuite\SeoMetaRobots\Setup\UpgradeData::ATTRIBUTE_CODE);

        if (!isset($productMetaRobotsAttribute['attribute_id']) || !$productMetaRobotsAttribute['attribute_id']) {
            return;
        }

        $productMetaRobotsAttributeId = $productMetaRobotsAttribute['attribute_id'];
        $eavSetup->updateAttribute($productEntityTypeId, $productMetaRobotsAttributeId, 'is_global', \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE);

        //Update category 'meta_robots' attribute
        $categoryEntityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $categoryMetaRobotsAttribute = $eavSetup->getAttribute($categoryEntityTypeId, \MageSuite\SeoMetaRobots\Setup\UpgradeData::ATTRIBUTE_CODE);

        if (!isset($categoryMetaRobotsAttribute['attribute_id']) || !$categoryMetaRobotsAttribute['attribute_id']) {
            return;
        }

        $categoryMetaRobotsAttributeId = $categoryMetaRobotsAttribute['attribute_id'];
        $eavSetup->updateAttribute($categoryEntityTypeId, $categoryMetaRobotsAttributeId, 'is_global', \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}

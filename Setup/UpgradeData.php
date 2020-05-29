<?php

namespace Visma\SeoMetaRobots\Setup;

class UpgradeData implements \Magento\Framework\Setup\UpgradeDataInterface
{
    const ATTRIBUTE_CODE = 'meta_robots';

    /**
     * @var \Magento\Eav\Setup\EavSetup
     */
    protected $eavSetup;

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    protected $moduleDataSetupInterface;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetupInterface
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetupInterface = $moduleDataSetupInterface;

        $this->eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetupInterface]);
    }

    public function upgrade(
        \Magento\Framework\Setup\ModuleDataSetupInterface $setup,
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $this->addMetaRobotsProductAttribute();
        }

        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $this->addMetaRobotsCategoryAttribute();
        }
    }

    protected function addMetaRobotsProductAttribute()
    {
        if (!$this->eavSetup->getAttributeId(\Magento\Catalog\Model\Product::ENTITY, self::ATTRIBUTE_CODE)) {
            $this->eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                self::ATTRIBUTE_CODE,
                [
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'type' => 'int',
                    'unique' => false,
                    'label' => 'Meta Robots',
                    'input' => 'select',
                    'source' => \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::class,
                    'group' => 'Search Engine Optimization',
                    'required' => false,
                    'sort_order' => 45,
                    'user_defined' => 1,
                    'searchable' => false,
                    'filterable' => false,
                    'filterable_in_search' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false
                ]
            );
        }
    }

    protected function addMetaRobotsCategoryAttribute()
    {
        if (!$this->eavSetup->getAttributeId(\Magento\Catalog\Model\Category::ENTITY, self::ATTRIBUTE_CODE)) {
            $this->eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                self::ATTRIBUTE_CODE,
                [
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'type' => 'int',
                    'unique' => false,
                    'label' => 'Meta Robots',
                    'input' => 'select',
                    'source' => \Visma\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::class,
                    'group' => 'Search Engine Optimization',
                    'required' => false,
                    'sort_order' => 45,
                    'user_defined' => 1,
                    'searchable' => false,
                    'filterable' => false,
                    'filterable_in_search' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false
                ]
            );
        }
    }
}

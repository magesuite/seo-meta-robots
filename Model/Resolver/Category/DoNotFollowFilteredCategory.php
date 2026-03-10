<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Resolver\Category;

class DoNotFollowFilteredCategory implements \MageSuite\SeoMetaRobots\Model\Resolver\RobotsTagResolverInterface
{
    protected const CATEGORY_VIEW_FULL_ACTION_NAME = 'catalog_category_view';

    public function __construct(
        protected \Magento\Framework\App\Request\Http $request,
        protected \Magento\Framework\Registry $registry,
        protected \MageSuite\SeoMetaRobots\Helper\Configuration $configuration,
        protected \MageSuite\SeoMetaRobots\Helper\MetaRobotsTag $metaRobotsTagHelper,
        protected \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $productAttributeCollectionFactory,
    ) {
    }

    public function resolve(): ?int
    {
        $filteredCategoryRobots = $this->configuration->getFilteredCategoryRobots();

        if ($filteredCategoryRobots === \MageSuite\SeoMetaRobots\Model\Config\Source\FilteredCategoryRobots::DEFAULT) {
            return null;
        }

        $category = $this->registry->registry('current_category');

        if (!$this->isCategoryViewPage() || !$this->isCategoryObject($category) || !$this->isFilteredCategory()) {
            return null;
        }

        return $filteredCategoryRobots;
    }

    protected function isCategoryObject(mixed $category): bool
    {
        return $category instanceof \Magento\Catalog\Model\Category;
    }

    protected function isCategoryViewPage(): bool
    {
        return $this->request->getFullActionName() === self::CATEGORY_VIEW_FULL_ACTION_NAME;
    }

    protected function isFilteredCategory(): bool
    {
        $keys = array_keys($this->request->getParams());

        if (empty($keys)) {
            return false;
        }

        return (bool)$this->productAttributeCollectionFactory->create()
            ->addFieldToFilter('attribute_code', ['in' => $keys])
            ->addIsFilterableFilter()
            ->getSize();
    }
}

<?php

declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model\Config\Source;

class FilteredCategoryRobots implements \Magento\Framework\Data\OptionSourceInterface
{
    public const DEFAULT = 0;

    public function toOptionArray() //phpcs:ignore
    {
        return [
            [
                'value' => self::DEFAULT,
                'label' => 'Default'
            ],
            [
                'value' => \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW,
                'label' => 'NOINDEX,NOFOLLOW'
            ],
            [
                'value' => \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW,
                'label' => 'NOINDEX,FOLLOW'
            ]
        ];
    }
}

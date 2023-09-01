<?php

namespace MageSuite\SeoMetaRobots\Model\Config\Source\Attribute;

class RobotsMetaTag extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource implements \Magento\Framework\Data\OptionSourceInterface
{
    const INDEX_FOLLOW = 1;
    const INDEX_NOFOLLOW = 2;
    const NOINDEX_FOLLOW = 3;
    const NOINDEX_NOFOLLOW = 4;

    public static array $tags = [
        'INDEX_FOLLOW' => self::INDEX_FOLLOW,
        'INDEX_NOFOLLOW' =>  self::INDEX_NOFOLLOW,
        'NOINDEX_FOLLOW' => self::NOINDEX_FOLLOW,
        'NOINDEX_NOFOLLOW' => self::NOINDEX_NOFOLLOW
    ];

    public static array $values = [
        self::INDEX_FOLLOW => 'INDEX,FOLLOW',
        self::INDEX_NOFOLLOW => 'INDEX,NOFOLLOW',
        self::NOINDEX_FOLLOW => 'NOINDEX,FOLLOW',
        self::NOINDEX_NOFOLLOW => 'NOINDEX,NOFOLLOW'
    ];

    protected array $options = [];

    public function getAllOptions()
    {
        if (empty($this->options)) {
            $this->options = [
                ['label' => 'INDEX,FOLLOW', 'value' => self::INDEX_FOLLOW],
                ['label' => 'INDEX,NOFOLLOW', 'value' => self::INDEX_NOFOLLOW],
                ['label' => 'NOINDEX,FOLLOW', 'value' => self::NOINDEX_FOLLOW],
                ['label' => 'NOINDEX,NOFOLLOW', 'value' => self::NOINDEX_NOFOLLOW]
            ];
        }

        return $this->options;
    }

    public function toOptionArray()
    {
        return $this->getAllOptions();
    }
}

<?php

namespace Visma\SeoMetaRobots\Model\Config\Source\Attribute;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;

class RobotsMetaTag extends AbstractSource implements OptionSourceInterface
{
    public const INDEX_FOLLOW = 1;
    public const INDEX_NOFOLLOW = 2;
    public const NOINDEX_FOLLOW = 3;
    public const NOINDEX_NOFOLLOW = 4;

    public static $tags = [
        'INDEX_FOLLOW' => self::INDEX_FOLLOW,
        'INDEX_NOFOLLOW' =>  self::INDEX_NOFOLLOW,
        'NOINDEX_FOLLOW' => self::NOINDEX_FOLLOW,
        'NOINDEX_NOFOLLOW' => self::NOINDEX_NOFOLLOW
    ];

    public static $values = [
        self::INDEX_FOLLOW => 'INDEX,FOLLOW',
        self::INDEX_NOFOLLOW => 'INDEX,NOFOLLOW',
        self::NOINDEX_FOLLOW => 'NOINDEX,FOLLOW',
        self::NOINDEX_NOFOLLOW => 'NOINDEX,NOFOLLOW'
    ];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return array
     */
    public function getAllOptions()
    {
        if (empty($this->options)) {
            $this->options = [
                ['label' => 'INDEX,FOLLOW', 'value' => self::INDEX_FOLLOW],
                ['label' => 'INDEX,NOFOLLOW', 'value' => self::INDEX_NOFOLLOW],
                ['label' => 'NOINDEX,FOLLOW', 'value' => self::NOINDEX_FOLLOW],
                ['label' => 'NOINDEX,NOFOLLOW', 'value' => self::NOINDEX_NOFOLLOW],
            ];
        }

        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }
}

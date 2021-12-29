<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Helper;

class MetaRobotsTag
{
    /**
     * @param int $option
     * @return bool
     */
    public function isNoIndexOption(int $option): bool
    {
        $noIndexOptions = [
            \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW,
            \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW
        ];

        return in_array($option, $noIndexOptions);
    }
}

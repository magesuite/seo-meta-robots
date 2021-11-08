<?php

namespace MageSuite\SeoMetaRobots\Helper;

class MetaRobotsTag
{
    /**
     * @param int $option
     * @return bool
     */
    public function isNoIndexOption(int $option): bool
    {
        if ($option === \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW
            || $option === \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW
        ) {
            return true;
        }

        return false;
    }
}

<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Helper;

class MetaRobotsTag
{
    public function isNoIndexOption(int $option): bool
    {
        $noIndexOptions = [
            \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_NOFOLLOW,
            \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::NOINDEX_FOLLOW
        ];

        return in_array($option, $noIndexOptions);
    }

    public function getFollowOption(int $option): ?string
    {
        $metaRobotsTag = \MageSuite\SeoMetaRobots\Model\Config\Source\Attribute\RobotsMetaTag::$values[$option] ?? null;

        if ($metaRobotsTag == null) {
            return null;
        }

        $parts = explode(',', $metaRobotsTag);

        return $parts[1] ?? null;
    }
}

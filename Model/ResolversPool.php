<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model;

class ResolversPool
{
    protected array $resolvers = [];

    public function __construct(array $resolvers = [])
    {
        $this->resolvers = $this->sortResolvers($resolvers);
    }

    public function getResolvers(): array
    {
        return $this->resolvers;
    }

    protected function sortResolvers(array $resolvers): array
    {
        usort($resolvers, function (array $resolverLeft, array $resolverRight) {
            if ($resolverLeft['sort_order'] == $resolverRight['sort_order']) {
                return 0;
            }

            return ($resolverLeft['sort_order'] < $resolverRight['sort_order']) ? -1 : 1;
        });

        return $resolvers;
    }
}

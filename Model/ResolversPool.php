<?php

namespace MageSuite\SeoMetaRobots\Model;

class ResolversPool
{
    /**
     * @var array
     */
    protected $resolvers;

    /**
     * ResolversPool constructor.
     * @param array $resolvers
     */
    public function __construct(array $resolvers = null)
    {
        $this->resolvers = $resolvers;
    }

    public function getResolvers()
    {
        if ($this->resolvers == null) {
            return [];
        }

        return $this->sortResolvers($this->resolvers);
    }

    /**
     * @param array $resolvers
     * @return array
     */
    private function sortResolvers(array $resolvers)
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

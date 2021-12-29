<?php
declare(strict_types=1);

namespace MageSuite\SeoMetaRobots\Model;

class ResolversPool
{
    /**
     * @var array
     */
    protected $resolvers;

    /**
     * @param array $resolvers
     */
    public function __construct(array $resolvers = [])
    {
        $this->resolvers = $this->sortResolvers($resolvers);
    }

    /**
     * @return array
     */
    public function getResolvers(): array
    {
        return $this->resolvers;
    }

    /**
     * @param array $resolvers
     * @return array
     */
    protected function sortResolvers(array $resolvers)
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

<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Action implements RobotsTagResolverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected array $actions = [];

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        array $actions = []
    ) {
        $this->request = $request;
        $this->actions = $actions;
    }

    public function resolve()
    {
        $action = $this->request->getFullActionName();

        if (in_array($action, array_keys($this->actions))) {
            return $this->actions[$action];
        }

        return null;
    }
}

<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Action implements RobotsTagResolverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var array
     */
    protected $actions;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        array $actions = []
    )
    {
        $this->request = $request;
        $this->actions = $actions;
    }

    /**
     * @inheritDoc
     */
    public function resolve()
    {
        $action = $this->request->getFullActionName();

        if(in_array($action, array_keys($this->actions))) {
            return $this->actions[$action];
        }

        return null;
    }
}
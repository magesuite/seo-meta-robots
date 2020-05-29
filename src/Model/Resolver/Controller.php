<?php

namespace Visma\SeoMetaRobots\Model\Resolver;

class Controller implements RobotsTagResolverInterface
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var array
     */
    protected $controllers;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        array $controllers = []
    ) {
        $this->request = $request;
        $this->controllers = $controllers;
    }

    /**
     * @inheritDoc
     */
    public function resolve()
    {
        $controller = sprintf('%s_%s', $this->request->getModuleName(), $this->request->getControllerName());

        if (in_array($controller, array_keys($this->controllers))) {
            return $this->controllers[$controller];
        }

        return null;
    }
}

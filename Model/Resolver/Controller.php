<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Controller implements RobotsTagResolverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected array $controllers = [];

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        array $controllers = []
    ) {
        $this->request = $request;
        $this->controllers = $controllers;
    }

    public function resolve()
    {
        $controller = sprintf('%s_%s', $this->request->getModuleName(), $this->request->getControllerName());

        if (in_array($controller, array_keys($this->controllers))) {
            return $this->controllers[$controller];
        }

        return null;
    }
}

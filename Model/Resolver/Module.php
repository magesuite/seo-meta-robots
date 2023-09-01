<?php

namespace MageSuite\SeoMetaRobots\Model\Resolver;

class Module implements RobotsTagResolverInterface
{
    protected \Magento\Framework\App\Request\Http $request;

    protected array $modules = [];

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        array $modules = []
    ) {
        $this->request = $request;
        $this->modules = $modules;
    }

    public function resolve()
    {
        $controllerModule = $this->request->getModuleName();

        if (in_array($controllerModule, array_keys($this->modules))) {
            return $this->modules[$controllerModule];
        }

        return null;
    }
}

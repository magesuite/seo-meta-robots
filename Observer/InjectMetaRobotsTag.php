<?php

namespace Visma\SeoMetaRobots\Observer;

class InjectMetaRobotsTag implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $pageConfig;

    /**
     * @var \Visma\SeoMetaRobots\Service\RobotsTagGenerator
     */
    protected $robotsTagGenerator;
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;

    public function __construct(
        \Magento\Framework\View\Page\Config $pageConfig,
        \Visma\SeoMetaRobots\Service\RobotsTagGenerator $robotsTagGenerator,
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->pageConfig = $pageConfig;
        $this->robotsTagGenerator = $robotsTagGenerator;
        $this->layout = $layout;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $pageLayout = $this->pageConfig->getPageLayout() ? $this->pageConfig->getPageLayout() : $this->layout->getUpdate()->getPageLayout();

        if (!$pageLayout) {
            return;
        }

        $robotsTagValue = $this->robotsTagGenerator->generate();

        $this->pageConfig->setRobots($robotsTagValue);
    }
}

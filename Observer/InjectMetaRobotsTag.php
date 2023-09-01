<?php

namespace MageSuite\SeoMetaRobots\Observer;

class InjectMetaRobotsTag implements \Magento\Framework\Event\ObserverInterface
{
    protected \Magento\Framework\View\Page\Config $pageConfig;

    protected \MageSuite\SeoMetaRobots\Service\RobotsTagGenerator $robotsTagGenerator;

    protected \Magento\Framework\View\LayoutInterface $layout;

    public function __construct(
        \Magento\Framework\View\Page\Config $pageConfig,
        \MageSuite\SeoMetaRobots\Service\RobotsTagGenerator $robotsTagGenerator,
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->pageConfig = $pageConfig;
        $this->robotsTagGenerator = $robotsTagGenerator;
        $this->layout = $layout;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $pageLayout = $this->pageConfig->getPageLayout() ?? $this->layout->getUpdate()->getPageLayout();

        if (!$pageLayout) {
            return;
        }

        $robotsTagValue = $this->robotsTagGenerator->generate();
        $this->pageConfig->setRobots($robotsTagValue);
    }
}

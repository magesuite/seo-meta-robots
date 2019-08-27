<?php

namespace MageSuite\SeoMetaRobots\Observer;

class InjectMetaRobotsTag implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $pageConfig;

    /**
     * @var \MageSuite\SeoMetaRobots\Service\RobotsTagGenerator
     */
    protected $robotsTagGenerator;

    public function __construct(
        \Magento\Framework\View\Page\Config $pageConfig,
        \MageSuite\SeoMetaRobots\Service\RobotsTagGenerator $robotsTagGenerator
    )
    {
        $this->pageConfig = $pageConfig;
        $this->robotsTagGenerator = $robotsTagGenerator;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $robotsTagValue = $this->robotsTagGenerator->generate();

        $this->pageConfig->setRobots($robotsTagValue);
    }
}

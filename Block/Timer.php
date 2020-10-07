<?php

namespace Iweb\Countdown\Block;

class Timer extends \Magento\Catalog\Block\Product\AbstractProduct
{
    protected $helper;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Iweb\Countdown\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        
        parent::__construct($context, $data);
    } 
    
    public function isModuleEnabled()
    {
        return $this->helper->isCountdownTimerEnabled();
    }
    
    public function getReleaseDate()
    {
        return $this->getProduct()->getReleaseDate();
    }
}

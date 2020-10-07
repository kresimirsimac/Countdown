<?php

namespace Iweb\Countdown\Controller\Index;

class Config extends \Magento\Framework\App\Action\Action
{
    protected $helperData;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Iweb\Countdown\Helper\Data $helperData
    )
    {
        $this->helperData = $helperData;
        parent::__construct($context);
    }
    
    public function execute()
    {
        // TODO : implement an execute method
        
        echo $this->helperData->getGeneralConfig('enable');
    }
}

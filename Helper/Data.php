<?php

namespace Iweb\Countdown\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_IWEB_COUNTDOWN_PREORDER_TIMER_CONFIGURATION_ENABLED = 'iweb_countdown/preorder_timer_configuration/enabled';
    
    public function isCountdownTimerEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_IWEB_COUNTDOWN_PREORDER_TIMER_CONFIGURATION_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }
}

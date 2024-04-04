<?php
namespace FME\Form\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

/**
 * Helper class for retrieving configuration settings
 */
class GuestFormEnable extends AbstractHelper
{
    /**
     * Retrieve the value of the "Enable" configuration setting
     *
     * @return mixed|null The value of the "Enable" configuration setting or null if not found
     */
    public function getStoreConfig()
    {    
        return $this->scopeConfig->getValue("configuration/guestFormValidation/enable");
    }
}

<?php
namespace FME\Form\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
       public function getStoreConfig()
       {    
            return $this->scopeConfig->getValue("moduleConfig/general/enable");
       }
}
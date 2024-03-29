<?php
namespace FME\Form\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\Session as CustomerSession;

class SessionInfo extends AbstractHelper
{
    protected $customerSession;
    public function __construct(CustomerSession $customerSession){
        $this->customerSession = $customerSession;
    }
    public function getUserSession(){
        // dd(!$this->customerSession->isLoggedIn());
        return !$this->customerSession->isLoggedIn();
    }
}


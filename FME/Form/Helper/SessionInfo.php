<?php
namespace FME\Form\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Helper class for retrieving user session information
 */
class SessionInfo extends AbstractHelper
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * SessionInfo constructor.
     *
     * @param CustomerSession $customerSession
     */
    public function __construct(CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    /**
     * Check if a user session is active
     *
     * @return bool True if no user session is active, otherwise false
     */
    public function getUserSession()
    {
        return !$this->customerSession->isLoggedIn();
    }
}

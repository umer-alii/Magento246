<?php
namespace FME\Form\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;

class RemoveBlock implements ObserverInterface
{
    protected $customerSession;
    protected $layoutFactory;

    public function __construct(
        CustomerSession $customerSession,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        $this->customerSession = $customerSession;
        $this->layoutFactory = $layoutFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // Check if the customer is logged in
        if ($this->customerSession->isLoggedIn()) {
            // Apply layout updates for logged-in state
            $this->applyLayoutUpdate('logged_in');
        } else {
            // Apply layout updates for logged-out state
            $this->applyLayoutUpdate('logged_out');
        }
    }

    protected function applyLayoutUpdate($handle)
    {
        $layout = $this->layoutFactory->create();
        $layout->getUpdate()->addHandle($handle);
        $layout->generateXml();
        $layout->generateElements();
    }
}

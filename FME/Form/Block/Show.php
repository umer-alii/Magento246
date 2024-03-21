<?php
namespace FME\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use FME\Form\Model\ResourceModel\Extension\CollectionFactory;
use Magento\Customer\Model\Session as CustomerSession;

class Show extends Template
{
    private $collectionobject;
    private $customerSession;

    public function __construct(
        Context $context,
        CollectionFactory $collectionobject,
        CustomerSession $customerSession,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collectionobject = $collectionobject;
        $this->customerSession = $customerSession;
    }

    public function getAllUsersData() {
        //dd('hi');
        $data = $this->collectionobject->create()->getData();
        dd($data);
        return $data;
    }

    public function getLoggedUsersData() {
        $allUserData = $this->collectionobject->create()->getData();
        $loggedInCustomerId = $this->customerSession->getCustomer()->getId();
        $loggedInCustomerUsername = $this->customerSession->getCustomer()->getUsername();

        //dd($loggedInCustomerId);
        //var_dump($this->customerSession->getCustomer()->getId());
        //dd($allUserData);
        $filteredUserData = [];
        foreach ($allUserData as $userData) {
            if ($userData['session_id'] == $loggedInCustomerId) {
                $filteredUserData[] = $userData;
            }
        }

        return $filteredUserData;
    }


}
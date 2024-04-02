<?php
namespace FME\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use FME\Form\Model\ResourceModel\Extension\CollectionFactory;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Class Show
 * Block to show user data
 */
class Show extends Template
{
    private $collectionobject;
    private $customerSession;

    /**
     * Constructor
     *
     * @param Context $context
     * @param CollectionFactory $collectionobject
     * @param CustomerSession $customerSession
     * @param array $data
     */
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

    /**
     * Get all users' data
     *
     * @return array
     */
    public function getAllUsersData() {
        $data = $this->collectionobject->create()->getData();
        return $data;
    }

    /**
     * Get logged in users' data
     *
     * @return array
     */
    public function getLoggedUsersData() {
        $allUserData = $this->collectionobject->create()->getData();
        $loggedInCustomerId = $this->customerSession->getCustomer()->getId();

        $filteredUserData = [];
        foreach ($allUserData as $userData) {
            if ($userData['session_id'] == $loggedInCustomerId) {
                $filteredUserData[] = $userData;
            }
        }

        return $filteredUserData;
    }

    /**
     * Prepare layout
     */
    protected function _prepareLayout(){
        parent::_prepareLayout();
        $this->pageConfig->getTitle()->set(__('My Pagination'));
        if ($this->getProductCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
            )->setAvailableLimit([5 => 5, 10 => 10, 15 => 15, 20 => 20])
            ->setShowPerPage(true)->setCollection(
                $this->getProductCollection()
            );
            $this->setChild('pager', $pager);
            $this->getProductCollection()->load();
        }
        return $this;
    }

    /**
     * Get pager HTML
     *
     * @return string
     */
    public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }

    /**
     * Get product collection
     *
     * @return mixed
     */
    public function getProductCollection(){
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5;
        $collection = $this->collectionobject->create();
        $collection->addFieldToFilter('session_id', $this->customerSession->getCustomer()->getId());
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;    
    }
}

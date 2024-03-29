<?php

namespace FME\Form\Controller\Customer;

use Magento\Framework\Controller\ResultFactory;
use FME\Form\Helper\Data;

class GuestForm extends \Magento\Framework\App\Action\Action
{
    private $datahelper;
    protected $resultPageFactory;
    protected $resultRedirectFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        Data $datahelper,
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $resultFactory;
        $this->datahelper = $datahelper;
    }

    public function execute()
    {
        if ($this->datahelper->getStoreConfig() === "1") {
            $resultPage = $this->resultPageFactory->create();
            return $resultPage;
        } else {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            $resultForward->forward('noroute');
            return $resultForward;
        }
    }
}
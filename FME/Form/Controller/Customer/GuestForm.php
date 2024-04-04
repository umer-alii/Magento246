<?php

namespace FME\Form\Controller\Customer;

use Magento\Framework\Controller\ResultFactory;
use FME\Form\Helper\ConfigureModule;
use FME\Form\Helper\GuestFormEnable;


/**
 * Controller class for handling guest form submission
 */
class GuestForm extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ConfigureModule
     */
    private $datahelper;

    /**
     * @var GuestFormEnable
     */
    private $enableGuestForm;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ResultFactory
     */
    protected $resultRedirectFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param ResultFactory $resultFactory
     * @param ConfigureModule $datahelper
     * @param GuestFormEnable $enableGuestForm
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        ConfigureModule $datahelper,
        GuestFormEnable $enableGuestForm
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $resultFactory;
        $this->datahelper = $datahelper;
        $this->enableGuestForm = $enableGuestForm;
    }

    /**
     * Execute action to handle guest form submission
     *
     * @return \Magento\Framework\Controller\Result\Redirect|\Magento\Framework\View\Result\Page
     */
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

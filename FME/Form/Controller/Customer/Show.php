<?php

namespace FME\Form\Controller\Customer;

use Magento\Framework\Controller\ResultFactory;
use FME\Form\Helper\ConfigureModule;

/**
 * Controller class for showing customer form based on configuration
 */
class Show extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ConfigureModule
     */
    private $datahelper;

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
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ResultFactory $resultFactory,
        ConfigureModule $datahelper
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $resultFactory;
        $this->datahelper = $datahelper;
    }

    /**
     * Execute action to show customer form based on configuration
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
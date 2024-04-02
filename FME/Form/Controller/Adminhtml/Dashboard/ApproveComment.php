<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use FME\Form\Model\ExtensionFactory;

/**
 * Controller class for approving comments in the admin dashboard
 */
class ApproveComment extends Action
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ExtensionFactory
     */
    protected $customModelFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param ExtensionFactory $customModelFactory
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        ExtensionFactory $customModelFactory
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->customModelFactory = $customModelFactory; 
    }

    /**
     * Execute action to approve comment
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        
        if ($entityId) {
            $customModel = $this->customModelFactory->create();
            $customModel->load($entityId);
        }

        $customModel->setData('admin_approval', '1');
        $customModel->setData('status', 'Approved');

        $customModel->save();

        $this->messageManager->addSuccessMessage(__('Comment Approved successfully.'));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}

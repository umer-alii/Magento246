<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use FME\Form\Model\ExtensionFactory;

class RefuseComment extends Action
{
    protected $resultFactory;
    protected $customModelFactory;

    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        ExtensionFactory $customModelFactory
    ) {
        parent::__construct($context);
        $this->resultFactory = $resultFactory;
        $this->customModelFactory = $customModelFactory; 
    }

    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        
        if ($entityId) {
            // Load custom model
            $customModel = $this->customModelFactory->create();
            $customModel->load($entityId);
        }

            $customModel->setData('admin_approval', '0');
            $customModel->setData('status', 'Refused');
            $customModel->save(); // Save changes
            $this->messageManager->addSuccessMessage(__('Comment UnApproved.'));

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
    }
}

<?php 
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use FME\Form\Model\ExtensionFactory;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $modelFactory;

    public function __construct(
        Context $context,
        ExtensionFactory $modelFactory
    ) {
        $this->modelFactory = $modelFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        
        try {
            $entity = $this->modelFactory->create()->load($entityId);
            
            if (!$entity->getId()) {
                throw new \Exception(__('Entity not found.'));
            }

            $entity->delete();

            $this->messageManager->addSuccessMessage(__('Entity deleted successfully.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}

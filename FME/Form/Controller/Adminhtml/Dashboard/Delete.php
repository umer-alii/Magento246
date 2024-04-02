<?php 
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use FME\Form\Model\ExtensionFactory;

/**
 * Controller class for deleting an entity in the admin dashboard
 */
class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var ExtensionFactory
     */
    protected $modelFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ExtensionFactory $modelFactory
     */
    public function __construct(
        Context $context,
        ExtensionFactory $modelFactory
    ) {
        $this->modelFactory = $modelFactory;
        parent::__construct($context);
    }

    /**
     * Execute action to delete an entity
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
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

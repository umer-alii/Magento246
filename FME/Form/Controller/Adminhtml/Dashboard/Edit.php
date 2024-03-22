<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
//use FME\Form\Model\ExtensionFactory; 
//use FME\Form\Model\Extension; 


class Edit extends Action
{
    protected $entity_id = null;
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $entity_id = $this->getRequest()->getParam('entity_id');

        $resultPage = $this->resultPageFactory->create();
       
        if($entity_id){
            $resultPage->getConfig()->getTitle()->prepend(__('Edit User'));
        }else{
            $resultPage->getConfig()->getTitle()->prepend(__('Add User'));
        }
        
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_Form::edit');
    }
}


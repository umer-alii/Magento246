<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Framework\View\Result\PageFactory;
 
class CreateForm extends \Magento\Backend\App\Action
{
    protected $resultPageFactory ;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        PageFactory $resultPageFactory,
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add User'));
        return $resultPage;

       // return $this->_forward('edit');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_Form::createform');
    }
}
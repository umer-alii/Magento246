<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller class for editing or adding a user in the admin dashboard
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action to render edit/add user page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('entity_id');

        $resultPage = $this->resultPageFactory->create();
       
        if ($entityId) {
            $resultPage->getConfig()->getTitle()->prepend(__('Edit User'));
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('Add User'));
        }
        
        return $resultPage;
    }

    /**
     * Check if action is allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_Form::edit');
    }
}

<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;
 
class CreateForm extends \Magento\Backend\App\Action
{
    protected $resultPageFactory ;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_forward('edit');
    }
}
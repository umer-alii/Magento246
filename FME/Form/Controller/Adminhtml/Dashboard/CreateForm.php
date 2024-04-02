<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;
 
/**
 * Controller class for creating a new form in the admin dashboard
 */
class CreateForm extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Execute action to forward to 'edit' action
     *
     * @return \Magento\Framework\Controller\Result\Forward
     */
    public function execute()
    {
        return $this->_forward('edit');
    }
}

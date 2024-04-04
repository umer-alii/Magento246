<?php
namespace FME\Form\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use FME\Form\Model\Extension as Model;
use Magento\Customer\Model\Session as CustomerSession;

/**
 * Controller class for saving product details submitted by customers
 */
class SaveProductDetails extends Action
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param Model $model
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Model $model,
        CustomerSession $customerSession
    ) {
        $this->resultFactory = $resultFactory;
        $this->model = $model;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * Execute action to save product details
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {   
        try {  
            $data = $this->getRequest()->getPostValue();
            // if ($this->customerSession->isLoggedIn()) {
                if (isset($data)) {

                    // dd($this->getRequest()->getPost('product_name'));
                    $subjectNames = $this->getRequest()->getPost('courses', []);
                    $data['subjects'] = implode(',', $subjectNames);
                    unset($data['courses']);

                    $professionNames = $this->getRequest()->getParam('profession',[]);     
                    $data['profession'] = implode(',', $professionNames);

                    $data['session_id'] = $this->customerSession->getCustomer()->getId();

                    $data['status'] = 'Pending';
                    
                    $model = $this->model->setData($data);
                    $this->model->save(); 
                    
                    $this->messageManager->addSuccessMessage(__("Your review is received successfully"));
                }
            }
            // else{
            //     $this->messageManager->addNotice(__("Please Login First"));
            //     $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            //     $resultRedirect->setUrl('/customer/account/login/');
            //     return $resultRedirect;
            // }
        catch (\Exception $e) {
            // dd($e);
            $this->messageManager->addNotice(__("Fill the required fields"));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;  
    }
}

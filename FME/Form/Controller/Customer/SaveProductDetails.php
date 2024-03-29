<?php
namespace FME\Form\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use FME\Form\Model\Extension as Model;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Validator\EmailAddress as EmailValidator;
use Magento\Framework\Event\ManagerInterface as EventManager;

class SaveProductDetails extends Action
{
    protected $resultFactory;
    protected $model;
    protected $customerSession;
    protected $eventManager;


    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Model $model,
        CustomerSession $customerSession,
        )
    {
        $this->resultFactory = $resultFactory;
        $this->model = $model;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {   
            try {  
                $data = $this->getRequest()->getPostValue();
                if (isset($data)) {
                    
                        $subjectNames = $this->getRequest()->getPost('courses', []);
                        $data['subjects'] = implode(',', $subjectNames);
                        unset($data['courses']);

                        $professionNames = $this->getRequest()->getParam('profession',[]);     
                        $data['profession'] = implode(',', $professionNames);

                        $data['session_id'] = $this->customerSession->getCustomer()->getId();

                        $data['status'] = 'Pending';
                       
                        $model = $this->model->setData($data);
                        $this->model->save(); 
                        
                        $this->messageManager->addSuccessMessage(__("Your review is recieved successfully"));
                                      
                }
            } catch (\Exception $e) {
                dd($e);
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
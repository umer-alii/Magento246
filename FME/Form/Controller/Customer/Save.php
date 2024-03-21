<?php
namespace FME\Form\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use FME\Form\Model\Extension as Model;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Validator\EmailAddress as EmailValidator;

class Save extends Action
{
    protected $resultFactory;
    protected $model;
    protected $customerSession;
    protected $emailValidator;

    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Model $model,
        CustomerSession $customerSession,
        EmailValidator $emailValidator
        )
    {
        $this->resultFactory = $resultFactory;
        $this->model = $model;
        $this->customerSession = $customerSession;
        $this->emailValidator = $emailValidator;
        parent::__construct($context);
    }

    public function execute()
    {   

        if(!$this->customerSession->isLoggedIn()){
            $this->messageManager->addErrorMessage(__("Please Login First"));
        }
        else{
            try {
                
                $data = $this->getRequest()->getPostValue();
                if ($data) {
                    $email = $this->getRequest()->getPost('email');
                    $isValid = $this->emailValidator->isValid($email);
                    //dd($isValid);
                    if($isValid){
                        $subjectNames = $this->getRequest()->getPost('courses', []);
                        $data['subjects'] = implode(',', $subjectNames);
                        unset($data['courses']);

                        $professionNames = $this->getRequest()->getParam('profession',[]);     
                        $data['profession'] = implode(',', $professionNames);

                        $data['session_id'] = $this->customerSession->getCustomer()->getId();
                        
                        //dd($data['profession']);
                        //unset($data['profession']);
                        //dd($professionNames);
                        //$data['entity_id'] = null;
                        // dd($data);
                        
                        $model = $this->model->setData($data);
                        //dd($model);
                        $this->model->save(); 
                        $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
                    }else{
                        $this->messageManager->addNotice(__("Email not correct!"));
                        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                        return $resultRedirect;
                    }
                    
                }
            } catch (\Exception $e) {
                $this->messageManager->addNotice(__("Fill the required fields"));
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }
        }
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_url->getUrl('orderbook/customer/show'));
        return $resultRedirect;

    }
}
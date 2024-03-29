<?php
namespace FME\Form\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use FME\Form\Model\Extension as Model;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Validator\EmailAddress as EmailValidator;
use Magento\Framework\Event\ManagerInterface as EventManager;

class Save extends Action
{
    protected $resultFactory;
    protected $model;
    protected $customerSession;
    protected $emailValidator;
    protected $eventManager;


    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Model $model,
        CustomerSession $customerSession,
        EmailValidator $emailValidator,
        EventManager $eventManager
        )
    {
        $this->resultFactory = $resultFactory;
        $this->model = $model;
        $this->customerSession = $customerSession;
        $this->emailValidator = $emailValidator;
        $this->eventManager = $eventManager;
        parent::__construct($context);
    }

    public function execute()
    {   
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
                        
                        $data['entity_id'] = $id;
                        
                        $data['status'] = 'Pending';

                        $model = $this->model->setData($data);

                        // $model->setEmail('umer.ali@unitedsol.net');
                        $this->eventManager->dispatch(
                            'adminMail',
                            ['customer' => $data]
                        );
                        $this->eventManager->dispatch(
                            'userMail',
                            ['customer' => $data]
                        );

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
                dd($e);
                $this->messageManager->addNotice(__("Fill the required fields"));
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }
        
        if(!$this->customerSession->isLoggedIn()){
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_url->getUrl());
            return $resultRedirect;
        }else{
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_url->getUrl('orderbook/customer/show'));
            return $resultRedirect;
        }
       

    }
}
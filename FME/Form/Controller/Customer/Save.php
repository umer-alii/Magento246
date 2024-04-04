<?php
namespace FME\Form\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use FME\Form\Model\Extension as Model;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Validator\EmailAddress as EmailValidator;
use Magento\Framework\Event\ManagerInterface as EventManager;
use FME\Form\Helper\GuestFormEnable;

/**
 * Controller class for handling customer form submission
 */
class Save extends Action
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
     * @var EmailValidator
     */
    protected $emailValidator;

    /**
     * @var EventManager
     */
    protected $eventManager;
    
    /**
     * @var GuestFormEnable
     */
    private $enableGuestForm;


    /**
     * Constructor
     *
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param Model $model
     * @param CustomerSession $customerSession
     * @param EmailValidator $emailValidator
     * @param EventManager $eventManager
     * @param GuestFormEnable $enableGuestForm
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Model $model,
        CustomerSession $customerSession,
        EmailValidator $emailValidator,
        EventManager $eventManager,
        GuestFormEnable $enableGuestForm
    ) {
        $this->resultFactory = $resultFactory;
        $this->model = $model;
        $this->customerSession = $customerSession;
        $this->emailValidator = $emailValidator;
        $this->eventManager = $eventManager;
        $this->enableGuestForm = $enableGuestForm;
        parent::__construct($context);
    }

    /**
     * Execute action to handle customer form submission
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {   
        try { 
            $data = $this->getRequest()->getPostValue();
            if ($data) {
                if ($this->enableGuestForm->getStoreConfig() === "1") {
                    
                    $subjectNames = $this->getRequest()->getPost('courses', []);
                    $data['subjects'] = implode(',', $subjectNames);
                    unset($data['courses']);
                    $professionNames = $this->getRequest()->getParam('profession',[]);     
                    $data['profession'] = implode(',', $professionNames);
                    $data['session_id'] = $this->customerSession->getCustomer()->getId();
                    $model = $this->model->setData($data);
                        
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
                }else {
                    $this->messageManager->addNotice(__("Please Login First!"));
                        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                        $resultRedirect->setUrl('/customer/account/login');
                        return $resultRedirect;
                }       
            }
            
        } catch (\Exception $e) {
            $this->messageManager->addNotice(__("Fill the required fields"));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
        
        if(!$this->customerSession->isLoggedIn()){
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_url->getUrl());
            return $resultRedirect;
        } else {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_url->getUrl('orderbook/customer/show'));
            return $resultRedirect;
        }
    }
}

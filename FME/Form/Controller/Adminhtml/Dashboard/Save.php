<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use FME\Form\Model\Extension as Model;
use \Magento\Framework\Controller\ResultFactory;

/**
 * Controller class for saving data in the admin dashboard
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @const COMMENT_PATH
     */
    const COMMENT_PATH = '/editcomment';
    /**
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Action\Context $context
     * @param ResultFactory $resultFactory
     * @param Model $model
     */
    public function __construct(
        Action\Context $context,
        ResultFactory $resultFactory,
        Model $model
    ) {
        parent::__construct($context);
        $this->model = $model;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Execute action to save data
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        
        try {
            $data = $this->getRequest()->getPostValue();
            $id = $this->getRequest()->getParam("product_id");
            if (isset($id) && !empty($id)) {
                $data['status'] = 'Pending';
                
                $professionNames = $this->getRequest()->getParam('profession',[]);     
                $data['profession'] = implode(',', $professionNames);

                $courses = $this->getRequest()->getParam('courses',[]);
                $data['courses'] = implode(',', $courses);

                $model = $this->model->setData($data);
                $this->model->save(); 
                $this->messageManager->addSuccessMessage(__("Data Edited Successfully."));      
            }
            else{
                $professionNames = $this->getRequest()->getParam('profession',[]);     
                $data['profession'] = implode(',', $professionNames);

                $courses = $this->getRequest()->getParam('courses',[]);
                $data['subjects'] = implode(',', $courses);
              
                $model = $this->model->setData($data);
                $this->model->save(); 
                $this->messageManager->addSuccessMessage(__("Data Added Successfully.")); 
            }
        } catch (\Exception $e) {
            $this->messageManager->addNotice(__("Fill the required fields"));
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
    
    $referrerUrl = $this->_redirect->getRefererUrl();

    
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (strpos($referrerUrl, self::COMMENT_PATH) !== false){
            $resultRedirect->setUrl($this->_url->getUrl('customroute/dashboard/reviewApproval'));
        }else{
            $resultRedirect->setUrl($this->_url->getUrl('customroute/dashboard/index'));
        }
        
        return $resultRedirect;
    }
}

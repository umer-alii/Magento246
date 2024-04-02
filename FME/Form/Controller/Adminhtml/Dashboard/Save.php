<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use FME\Form\Model\Extension as Model;
use \Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $model;
    private const pending = 'Pending';
    public function __construct(
        Action\Context $context,
        ResultFactory $resultFactory,
        Model $model
    ) {
        parent::__construct($context);
        $this->model = $model;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
            try {
                $data = $this->getRequest()->getPostValue();
                $id = $this->getRequest()->getParam("product_id");
                if (isset($id) && !empty($id)) {
                    $data['status'] = 'Pending';
                    
                    $professionNames = $this->getRequest()->getParam('profession',[]);     
                    $data['profession'] = implode(',', $professionNames);
                    $model = $this->model->setData($data);
                    $this->model->save(); 
                    $this->messageManager->addSuccessMessage(__("Data Edited Successfully."));      
                }
                else{
                    $professionNames = $this->getRequest()->getParam('profession',[]);     
                    $data['profession'] = implode(',', $professionNames);
                    
                    $model = $this->model->setData($data);
                    $this->model->save(); 
                    $this->messageManager->addSuccessMessage(__("Data Added Successfully.")); 
                }
            } catch (\Exception $e) {
                dd($e);
                $this->messageManager->addNotice(__("Fill the required fields"));
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_url->getUrl('customroute/dashboard/index'));
        return $resultRedirect;

    }
}
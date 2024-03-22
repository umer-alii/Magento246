<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use FME\Form\Model\Extension as Model;
use \Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $model;

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
               // dd($data);
                $id = $this->getRequest()->getParam("entity_id");
                //dd($id);
                //dd($data);
                if (isset($id)&& !empty($id)) {
                    //dd('hi');
                        $data['entity_id'] = $id;
                        //dd($data);
                        $model = $this->model->setData($data);
                        $this->model->save(); 
                        $this->messageManager->addSuccessMessage(__("Data Edited Successfully."));      
                }
                else{
                    //dd($data);
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
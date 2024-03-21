<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use FME\Form\Model\Extension as Model;
use \Magento\Framework\Controller\ResultFactory;

class Save extends \Magento\Backend\App\Action
{
    protected $Custommodel;

    public function __construct(
        Action\Context $context,
        ResultFactory $resultFactory,
        Model $model,
    ) {
        parent::__construct($context);
        $this->Custommodel = $model;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        dd('hi');
        echo "djhsfb";exit;
            try {
                $data = $this->getRequest()->getParams();
                dd($data);
                if ($data) {

                        //dd($data['profession']);
                        //unset($data['profession']);
                        //dd($professionNames);
                        //$data['entity_id'] = null;
                        // dd($data);
                        $model = $this->model->setData($data);
                        //dd($model);
                        $this->model->save(); 
                        $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));      
                }
            } catch (\Exception $e) {
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
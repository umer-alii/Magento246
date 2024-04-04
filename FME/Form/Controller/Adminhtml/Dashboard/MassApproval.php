<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use FME\Form\Model\ResourceModel\Extension\Collection;

class MassApproval extends Action
{
    public $collection;
    public $filter;
    protected $resultRedirectFactory;
    protected $resultPageFactory ;

    public function __construct(
        Context $context,
        Filter $filter,
        Collection $collection,
        ResultFactory $resultFactory,
        ) {
            $this->filter = $filter;
            $this->collection = $collection;
            parent::__construct($context);
            $this->resultRedirectFactory = $resultFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collection)->addFieldToFilter('product_id', ['notnull' => true]);
            
            $collectionSize = $collection->getSize();
            foreach ($collection as $model) {
                
                if (!$model->getId()) {
                    throw new \Exception(__('Entity not found.'));
                } else {
                    $model->setData('status', 'Approved'); 
                    $model->setData('admin_approval', '1');
                    $model->save();
                }
            }
            $this->messageManager->addSuccess(__('A total of %1 records have been approved.', $collectionSize));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $resultRedirect = $this->resultRedirectFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('customroute/dashboard/reviewapproval'); 
        return $resultRedirect;
    }

}
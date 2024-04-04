<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use FME\Form\Model\ResourceModel\Extension\CollectionFactory;

/**
 * Controller class for mass deletion of records in the admin dashboard
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * @const COMMENT_PATH
     */
    const COMMENT_PATH = '/reviewApproval';

    /**
     * @var Filter
     */
    protected $filter;
    
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Execute action to perform mass deletion
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $referrerUrl = $this->_redirect->getRefererUrl();

        if (strpos($referrerUrl, self::COMMENT_PATH) !== false){
            $collection = $this->filter->getCollection($this->collectionFactory->create())->addFieldToFilter('product_id', ['notnull' => true]);
        }else{
            $collection = $this->filter->getCollection($this->collectionFactory->create())->addFieldToFilter('product_id', ['null' => true]);
        }
        
        $collectionSize = $collection->getSize();
        
        foreach ($collection as $item) {
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (strpos($referrerUrl, self::COMMENT_PATH) !== false){
            return $resultRedirect->setPath('*/*/reviewapproval');        
        }else{
            return $resultRedirect->setPath('*/*/');
        }
        
        
    }
}

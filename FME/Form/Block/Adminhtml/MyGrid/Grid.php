<?php
namespace FME\Form\Block\Adminhtml\MyGrid;

use FME\Form\Model\ResourceModel\Extension\CollectionFactory as MyCustomCollectionFactory;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $moduleManager;
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param MyCustomCollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Module\Manager $moduleManager,
        MyCustomCollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->moduleManager = $moduleManager;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Set grid properties
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('postGrid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);
        $this->setVarNameFilter('post_filter');
    }

    /**
     * Prepare collection
     */
    protected function _prepareCollection()
    {
        /** @var \FME\Form\Model\ResourceModel\Extension\Collection $collection */
        $collection = $this->collectionFactory->create();

        // Filter out records where product_id is not null
        $collection->addFieldToFilter('product_id', ['notnull' => true])->addFieldToFilter('admin_approval', 1);

        $productId = $this->getRequest()->getParam('id'); 

        $collection->addFieldToFilter('product_id', $productId);

        $this->setCollection($collection);

        parent::_prepareCollection();

        return $this;
    }

    /**
     * Prepare grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'entity_id',
            [
                'header' => __('Entity ID'),
                'index' => 'entity_id',
                'type' => 'number',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name'
            ]
        );

        $this->addColumn(
            'email',
            [
                'header' => __('Email'),
                'index' => 'email'
            ]
        );

        $this->addColumn(
            'product_id',
            [
                'header' => __('Product Id'),
                'index' => 'product_id'
            ]
        );

        $this->addColumn(
            'product_sku',
            [
                'header' => __('Product Sku'),
                'index' => 'product_sku'
            ]
        );

        $this->addColumn(
            'comments',
            [
                'header' => __('Comment'),
                'index' => 'comments'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get grid url
     */
    public function getGridUrl()
    {
        return $this->getUrl('[myurl]/index/index', ['_current' => true]);
    }

    /**
     * Get row url
     */
    public function getRowUrl($row)
    {
        return '#';
    }
}

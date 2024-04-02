<?php
/**
 * Class ProductDataProvider
 *
 * @package FME\Form\Model
 */
namespace FME\Form\Model;

use FME\Form\Model\ResourceModel\Extension\Grid\CollectionFactory;

/**
 * Class ProductDataProvider
 * @package FME\Form\Model
 */
class ProductDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \FME\Form\Model\ResourceModel\Extension\Grid\Collection
     */
    protected $collection;

    /**
     * @var array|null
     */
    protected $loadedData;

    /**
     * ProductDataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $items = $this->getCollection()->addFieldToFilter('product_id', ['notnull' => true])->toArray();

        return $items;
    }
}

<?php
namespace FME\Form\view\adminhtml\UI;

use FME\Form\Model\ResourceModel\Extension\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $collection = $collectionFactory->create();
        $loadedData = $this->collection->getSelect()->where('product_id IS NOT NULL'); 
        dd($collection);
        $loadedData->load();

        $data = [];
        foreach ($this->loadedData->getItems() as $item) {
            $data[$item->getId()] = $item->getData();
        }

        return ['totalRecords' => $this->loadedData->getSize(), 'items' => $data];
    }
}

<?php

namespace FME\Form\Model;
 
use FME\Form\Model\ResourceModel\Extension\Collection;
 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;
    protected $collection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \FME\Form\Model\ResourceModel\Extension\Collection $userCollection
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $userCollection
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName);
        $this->collection = $userCollection;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
        // if (isset($this->_loadedData)) {
        //     return $this->_loadedData;
        // }
        // $items = $this->collection->getItems();
        // foreach ($items as $user) {
        //     $this->_loadedData[$user->getId()] = $user->getData();
        // }
        // return $this->_loadedData;
    }
}
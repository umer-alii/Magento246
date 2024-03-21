<?php
namespace FME\Form\Model\ResourceModel\Extension;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use FME\Form\Model\Extension as Model;
use FME\Form\Model\ResourceModel\Extension as ResourceModel;

class Collection extends AbstractCollection
{
//  protected $_idFieldName = 'entity_id';
   
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}

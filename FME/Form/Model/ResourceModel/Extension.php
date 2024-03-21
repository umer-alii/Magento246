<?php
namespace FME\Form\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Extension extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('FormData', 'entity_id');
    }
}

<?php
namespace FME\Form\Model;

use Magento\Framework\Model\AbstractModel;

class Extension extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\FME\Form\Model\ResourceModel\Extension::class);
    }
}

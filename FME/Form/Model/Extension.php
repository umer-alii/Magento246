<?php
namespace FME\Form\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Class Extension
 * @package FME\Form\Model
 */
class Extension extends AbstractModel
{
    /**
     * Initialize model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\FME\Form\Model\ResourceModel\Extension::class);
    }
}
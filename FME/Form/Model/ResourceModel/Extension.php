<?php
namespace FME\Form\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Extension
 * @package FME\Form\Model\ResourceModel
 */
class Extension extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('fme_form_data', 'entity_id');
    }
}


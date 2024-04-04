<?php
Namespace FME\Form\Block\Adminhtml\Catalog\Product;

use Magento\Backend\Block\Widget\Tab\TabInterface;

class ReviewTab extends \Magento\Backend\Block\Widget\Tab implements TabInterface
{
    protected $_template = 'catalog/product/edit/tab/grid.phtml';

    public function getTabLabel()
    {
        return __('Custom Tab');
    }

    public function getTabTitle()
    {
        return __('Custom Tab');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
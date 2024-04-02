<?php

namespace FME\Form\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

/**
 * Class SaveButton
 * Defines the Save button for adminhtml forms
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save'), 
            'class' => 'save primary', 
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']], 
                'form-role' => 'save' 
            ],
            'sort_order' => 90, 
        ];
    }
}

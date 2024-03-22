<?php

namespace FME\Form\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class BackButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'onclick' => 'setLocation(\'' . $this->getUrl('*/*/') . '\')',
            'class' => 'back',
            'sort_order' => 10
        ];
    }

}
<?php

namespace FME\Form\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class BackButton
 * Provides back button functionality for adminhtml forms
 */
class BackButton implements ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     */
    public function __construct(\Magento\Framework\App\Response\RedirectInterface $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {     
        $redirectUrl = $this->redirect->getRedirectUrl();
        
        return [
            'label' => __('Back'), 
            'on_click' => sprintf("location.href = '%s';", $redirectUrl), 
            'class' => 'back',
            'sort_order' => 10, 
        ];
    }
}

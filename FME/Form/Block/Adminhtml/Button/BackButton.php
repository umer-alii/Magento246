<?php

namespace FME\Form\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

use Magento\Framework\Controller\ResultFactory;

class BackButton implements ButtonProviderInterface {
    protected $redirect;
    public function __construct(\Magento\Framework\App\Response\RedirectInterface $redirect){
        $this->redirect = $redirect;
    }

    public function getButtonData() {     
        $redirectUrl = $this->redirect->getRedirectUrl();
        //dd($redirectUrl);
        return [
            'label' => __( 'Back' ),
            'on_click' =>  sprintf( "location.href = '%s';", $redirectUrl ),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }

    // public function getBackUrl() {
    //     return $this->getUrl( '*/*/index' );
    // }
}
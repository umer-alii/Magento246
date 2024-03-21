<?php

namespace FME\Form\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;

class GenericButton {
    protected $context;
    protected $blockRepository;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getBlockId() {
        return null;
    }

    public function getUrl( $route = '', $params = [] ) {
        return $this->context->getUrlBuilder()->getUrl( $route, $params );
    }
}

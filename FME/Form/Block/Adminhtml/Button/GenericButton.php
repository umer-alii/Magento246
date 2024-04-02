<?php

namespace FME\Form\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;

/**
 * Class GenericButton
 * Provides generic button functionality for adminhtml blocks
 */
class GenericButton
{
    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;

    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Get the block ID
     *
     * @return null
     */
    public function getBlockId()
    {
        return null;
    }

    /**
     * Get URL
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

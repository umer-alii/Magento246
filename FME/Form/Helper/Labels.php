<?php

namespace FME\Form\Helper;

/**
 * Helper class for retrieving labels from configuration settings
 */
class Labels extends \Magento\Framework\App\Helper\AbstractHelper {   

    const COMMENT_LABEL = 'labelConfiguration/Label/commentLabel';
    const GUEST_FORM_LABEL = 'labelConfiguration/Label/guestFormLabel';
    const LOGGEDIN_USER_FORM_LABEL= 'labelConfiguration/Label/userFormLabel';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Labels constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ){
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Retrieve the comment label from configuration settings
     *
     * @return string|null The comment label or null if not found
     */
    public function getCommentLabel() {
        return $this->scopeConfig->getValue(self::COMMENT_LABEL);
    }

    /**
     * Retrieve the guest form label from configuration settings
     *
     * @return string|null The guest form label or null if not found
     */
    public function getGuestFormLabel() {
        return $this->scopeConfig->getValue(self::GUEST_FORM_LABEL);
    }

    /**
     * Retrieve the logged-in user form label from configuration settings
     *
     * @return string|null The logged-in user form label or null if not found
     */
    public function getUserFormLabel() {
        return $this->scopeConfig->getValue(self::LOGGEDIN_USER_FORM_LABEL);
    }
}

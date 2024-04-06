<?php

namespace FME\Form\Helper;

/**
 * Helper class for retrieving email from configuration settings
 */
class GetEmails extends \Magento\Framework\App\Helper\AbstractHelper {   

    const ADMIN_NAME = 'configuration/email/adminName';
    const SENDER_NAME = 'configuration/email/senderName';
    const ADMIN_EMAIL = 'configuration/email/senderEmail';
    const SENDER_EMAIL = 'configuration/email/adminEmail';
    const ADMIN_EMAIL_TEMPLATE = 'configuration/templates/contact_email_admin_template';
    // const ADMIN_EMAIL_TEMPLATE_2 = 'configuration/templates/contact_email_admin_template2';
    const USER_EMAIL_TEMPLATE = 'configuration/templates/contact_email_user_template';

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
     * Retrieve the sender name from configuration settings
     *
     * @return string|null The sender name or null if not found
     */
    public function getSenderName() {
        return $this->scopeConfig->getValue(self::SENDER_NAME);
    }

    /**
     * Retrieve the sender email from configuration settings
     *
     * @return string|null The sender email or null if not found
     */
    public function getSenderEmail() {
        return $this->scopeConfig->getValue(self::SENDER_EMAIL);
    }

    /**
     * Retrieve the admin name from configuration settings
     *
     * @return string|null The admin name or null if not found
     */
    public function getAdminName() {
        return $this->scopeConfig->getValue(self::ADMIN_NAME);
    }

    /**
     * Retrieve the admin email from configuration settings
     *
     * @return string|null The admin email or null if not found
     */
    public function getAdminEmail() {
        return $this->scopeConfig->getValue(self::ADMIN_EMAIL);
    }

    /**
     * Retrieve the user email tempalte from configuration settings
     *
     * @return string|null The user email tempalte or null if not found
     */
    public function getUserEmailTemplate() {
        return $this->scopeConfig->getValue(self::USER_EMAIL_TEMPLATE);
    }

    /**
     * Retrieve the admin email tempalte from configuration settings
     *
     * @return string|null The admin email tempalte or null if not found
     */
    public function getAdminEmailTemplate() {
        // $email_temp = [];
        // $email_temp.push($this->scopeConfig->getValue(self::ADMIN_EMAIL_TEMPLATE));
        return $this->scopeConfig->getValue(self::ADMIN_EMAIL_TEMPLATE);
    }



}

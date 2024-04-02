<?php
 
namespace FME\Form\Observer;

use Magento\Framework\Event\ObserverInterface;
 
/**
 * Observer class for sending mail to user after form submission
 */
class SendMailToUser implements ObserverInterface
{
    /**
     * Email recipient configuration path
     */
    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;
    
    /**
     * Constructor
     *
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Escaper $escaper
     */
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
    }
 
    /**
     * Execute observer method
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getData('customer');
        
        $this->inlineTranslation->suspend();
        try
        {
            $error = false;
            
            $sender = [
                'name' => $customer['name'],
                'email' => $customer['email']
            ];

            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($customer);

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier('contact_email_user_template') 
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom(['name' => 'admin','email' => 'umer.ali@unitedsol.net'])
                ->addTo($customer['email'])
                ->getTransport();

            $transport->sendMessage();

            $this->inlineTranslation->resume();
            
        }
        catch (\Exception $e)
        {
            \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
        }
    }
}

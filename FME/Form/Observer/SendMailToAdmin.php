<?php
 
namespace FME\Form\Observer;

use Magento\Framework\Event\ObserverInterface;
use FME\Form\Helper\GetEmails;
 
/**
 * Observer class for sending mail to admin when a customer submits a form
 */
class SendMailToAdmin implements ObserverInterface
{
    /**
     * @var \FME\Form\Helper\GetEmails
     */
    protected $email;

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
     * @param \FME\Form\Helper\GetEmails $email
     */
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper,
        GetEmails $email
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->_escaper = $escaper;
        $this->email = $email;
    }
 
    /**
     * Execute observer method
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // dd($this->email->getAdminEmailTemplate());
        $customer = $observer->getData('customer');
        $this->inlineTranslation->suspend();
        try
        {
            $error = false;
            
            $sender = [
                'name' => $customer['name'],
                'email' => $customer['email'],
                'gender' => $customer['gender'],
                'address' => $customer['address'],
                'phone' => $customer['phone'],
                'date' => $customer['birthdate'],
                'subjects' => $customer['subjects'],
                'comments' => $customer['comments']
            ];

            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($sender);

            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            
           
            $transport = $this->_transportBuilder
                ->setTemplateIdentifier($this->email->getAdminEmailTemplate()) 
                ->setTemplateOptions(['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom(['name' => $this->email->getSenderName(), 'email' => $this->email->getSenderEmail()])
                ->addTo($this->email->getAdminEmail())
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

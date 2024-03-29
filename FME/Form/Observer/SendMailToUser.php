<?php
 
namespace FME\Form\Observer;

use Magento\Framework\Event\ObserverInterface;
 
class SendMailToUser implements ObserverInterface
{
 
    const XML_PATH_EMAIL_RECIPIENT = 'trans_email/ident_general/email';
    protected $_transportBuilder;
    protected $inlineTranslation;
    protected $scopeConfig;
    protected $storeManager;
    protected $_escaper;
    
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
            //dd($customer['email']);
            $postObject = new \Magento\Framework\DataObject();
            $postObject->setData($customer);
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport =
                $this->_transportBuilder
                ->setTemplateIdentifier('contact_email_user_template') 
                ->setTemplateOptions(
                    ['area' => \Magento\Framework\App\Area::AREA_FRONTEND, 
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,]
                )
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
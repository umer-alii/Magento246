<?php 
namespace FME\Form\Block;

use Magento\Customer\Model\SessionFactory as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountriesFactory; 
use FME\Form\Model\ResourceModel\Extension\CollectionFactory;

class getUserDetails extends Template
{

    protected $customerSession;
    protected $httpContext;
    public $countryCollection;
    protected $registry;
    public $collectionObject;

    public function __construct(
        CustomerSession $customerSession,
        Context $context,
        HttpContext $httpContext,
        CountriesFactory $countryCollection,
        \Magento\Framework\Registry $registry,
        CollectionFactory $collectionObject,
        array $data = []
    ) {
        parent::__construct($context,$data);
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
        $this->countryCollection = $countryCollection;
        $this->registry = $registry;
        $this->collectionObject = $collectionObject;
    }

    public function getAllUsersData() {
        //dd('hi');
        $data = $this->collectionObject->create()->getData();
        // dd($data);
        return $data;
    }

    public function getUserDetails()
    {
        //dd('hi');
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        if ($isLoggedIn) {
            // dd($isLoggedIn);
            $customer = $this->customerSession->create()->getCustomer();
            
            $customerData = [
                'name' => strval($customer->getName()),
                'email' => $customer->getEmail(),
                'gender' => $customer->getGender()
            ];
            //dd($customerData);
            return $customerData;
        } else {
            return null;
            // return $customerData = [
            //     'name' => null,
            //     'email' => null,
            //     'gender' => null,
            // ];
        }

    }

    public function getCountries(){

        $countries = [];

        foreach ($this->countryCollection->create() as $country) {
            $countries[$country->getCountryId()] = $country->getName();
        }
        return $countries;
    }
    
    public function userLoggedIn(){
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        if($isLoggedIn){
            return false;
        }else{
            return true;
        }
        
    }

    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    public function getCurrentProductId()
    {
        $currentProduct = $this->getCurrentProduct();
        if ($currentProduct) {
            return $currentProduct->getId();
        }
        return null;
    }
    public function getCurrentProductName()
    {
        $currentProduct = $this->getCurrentProduct();
        if ($currentProduct) {
            return $currentProduct->getName();
        }
        return null;
    }
}

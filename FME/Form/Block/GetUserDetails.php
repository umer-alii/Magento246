<?php 
namespace FME\Form\Block;

use Magento\Customer\Model\SessionFactory as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountriesFactory; 

class getUserDetails extends Template
{

    protected $customerSession;
    protected $httpContext;
    public $countryCollection;

    public function __construct(
        CustomerSession $customerSession,
        Context $context,
        HttpContext $httpContext,
        CountriesFactory $countryCollection,
        array $data = []
    ) {
        parent::__construct($context,$data);
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
        $this->countryCollection = $countryCollection;
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
    
}

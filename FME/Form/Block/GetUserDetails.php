<?php 
namespace FME\Form\Block;

use Magento\Customer\Model\SessionFactory as CustomerSession;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountriesFactory; 
use FME\Form\Model\ResourceModel\Extension\CollectionFactory;

/**
 * Class getUserDetails
 * Block to fetch user details
 */
class getUserDetails extends Template
{
    protected $customerSession;
    protected $httpContext;
    public $countryCollection;
    protected $registry;
    public $collectionObject;
    public $label;

    /**
     * Constructor
     *
     * @param CustomerSession $customerSession
     * @param Context $context
     * @param HttpContext $httpContext
     * @param CountriesFactory $countryCollection
     * @param \Magento\Framework\Registry $registry
     * @param \FME\Form\Helper\Labels $label
     * @param CollectionFactory $collectionObject
     * @param array $data
     */
    public function __construct(
        CustomerSession $customerSession,
        Context $context,
        HttpContext $httpContext,
        CountriesFactory $countryCollection,
        \Magento\Framework\Registry $registry,
        \FME\Form\Helper\Labels $label,
        CollectionFactory $collectionObject,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->httpContext = $httpContext;
        $this->countryCollection = $countryCollection;
        $this->registry = $registry;
        $this->collectionObject = $collectionObject;
        $this->label = $label;
    }

    /**
     * Get all users' data
     *
     * @return array
     */
    public function getAllUsersData() {
        $data = $this->collectionObject->create()->getData();
        return $data;
    }

    /**
     * Get user details
     *
     * @return array|null
     */
    public function getLoggedUserDetails()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        if ($isLoggedIn) {
            $customer = $this->customerSession->create()->getCustomer();
            $customerData = [
                'name' => strval($customer->getName()),
                'email' => $customer->getEmail(),
                'gender' => $customer->getGender()
            ];
            return $customerData;
        } else {
            return null;   
        }
    }

    /**
     * Get countries
     *
     * @return array
     */
    public function getCountries()
    {
        $countries = [];
        foreach ($this->countryCollection->create() as $country) {
            $countries[$country->getCountryId()] = $country->getName();
        }
        return $countries;
    }
    
    /**
     * Check if the user is logged in
     *
     * @return bool
     */
    public function userLoggedIn()
    {
        $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
        return !$isLoggedIn;
    }

    /**
     * Get the label for the guest form
     *
     * @return string
     */
    public function getGuestFormLabel()
    {
        return $this->label->getGuestFormLabel();
    }

    /**
     * Get the current product from the registry
     *
     * @return mixed|null
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get the ID of the current product
     *
     * @return int|null
     */
    public function getCurrentProductId()
    {
        $currentProduct = $this->getCurrentProduct();
        return $currentProduct ? $currentProduct->getId() : null;
    }

    /**
     * Get the comments of the current product
     *
     * @return string|null
     */

    public function getComments(){
        $comments = $this->collectionObject->create()
        ->addFieldToFilter('product_id', $this->getCurrentProductId())
        ->addFieldToFilter('admin_approval', '1')
        ->addOrder('created_at', 'DESC')
        ->getData();
        
        return array_reverse($comments);
    }

    /**
     * Get the name of the current product
     *
     * @return string|null
     */

    public function getCurrentProductName()
    {
        $currentProduct = $this->getCurrentProduct();
        return $currentProduct ? $currentProduct->getName() : null;
    }

    /**
     * Get the sku of the current product
     *
     * @return string|null
     */

    public function getCurrentProductSku()
    {
        $currentProduct = $this->getCurrentProduct();
        return $currentProduct ? $currentProduct->getSku(): null;
    }

    /**
     * Get the customerID of the current product
     *
     * @return string|null
     */

    public function getCurrentCustomerId(){
        $customerId = $this->customerSession->create()->getCustomerId();
        return $customerId;
    }

    /**
     * Check comment exist or not
     *
     * @return string|null
     */

    public function checkCommentExist($productId, $customerId){
        $check = false;
        $data = $this->collectionObject->create()->addFieldToFilter('product_id', $productId)->getCollection();
        foreach($data['customer_id'] as $id){
            if($id = $customerId){
                $check = true;
            }
        }
        return $check;
    }
}

<?php
namespace FME\Form\Model\Config\Source;
 
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountriesFactory; 
 
class Country implements OptionSourceInterface
{
    /**
     * @var CountryFactory
     */
    public $countryCollection;

    public function __construct(
        CountriesFactory $countryCollection
    ) {
        $this->countryCollection = $countryCollection;
    }
 
    public function toOptionArray()
    {
        $options[] = ['label' => '-- Please Select --', 'value' => ''];
        $countries = $this->countryCollection->create();
        foreach ($countries as $country) {
            $options[] = [
                'label' => $country->getName(),
                'value' => $country->getName(),
            ];
        }
 
        return $options;
    }
}
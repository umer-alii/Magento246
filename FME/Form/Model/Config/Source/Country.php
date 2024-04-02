<?php
namespace FME\Form\Model\Config\Source;
 
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountriesFactory; 

/**
 * Class Country
 * Provides options for selecting countries
 */
class Country implements OptionSourceInterface
{
    /**
     * @var CountriesFactory
     */
    public $countryCollection;

    /**
     * Constructor
     *
     * @param CountriesFactory $countryCollection
     */
    public function __construct(
        CountriesFactory $countryCollection
    ) {
        $this->countryCollection = $countryCollection;
    }
 
    /**
     * Retrieve options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        // Initialize options array with default label and value
        $options[] = ['label' => '-- Please Select --', 'value' => ''];

        // Retrieve country collection
        $countries = $this->countryCollection->create();

        // Iterate through countries and add them to options array
        foreach ($countries as $country) {
            $options[] = [
                'label' => $country->getName(), // Country name as label
                'value' => $country->getName(), // Country name as value
            ];
        }

        return $options;
    }
}

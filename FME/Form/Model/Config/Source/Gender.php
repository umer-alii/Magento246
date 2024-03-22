<?php namespace FME\Form\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Gender implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Male',
                'value' => 'Male'
            ],
            1 => [
                'label' => 'Female',
                'value' => 'Female'
            ]
        ];

        return $options;
    }
}
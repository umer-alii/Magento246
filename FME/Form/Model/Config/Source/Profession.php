<?php
namespace FME\Form\Model\Config\Source;
 
use Magento\Framework\Data\OptionSourceInterface;
 
class Profession implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'Frontend Developer', 'label' => __('Frontend Developer')],
            ['value' => 'Backend Developer', 'label' => __('Backend Developer')],
            ['value' => 'Full Stack Developer', 'label' => __('Full Stack Developer')],
            ['value' => 'Tester', 'label' => __('Tester')],
            ['value' => 'Support', 'label' => __('Support')],
            ['value' => 'HR', 'label' => __('HR')]
        ];
    }
}
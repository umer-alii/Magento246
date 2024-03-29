<?php
namespace FME\Form\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Courses implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'Math', 'label' => __('Math')],
            ['value' => 'Science', 'label' => __('Science')],
            ['value' => 'History', 'label' => __('History')],
            ['value' => 'CS', 'label' => __('CS')],
        ];
    }
}
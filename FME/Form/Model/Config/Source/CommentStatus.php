<?php namespace FME\Form\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class CommentStatus implements ArrayInterface
{
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Pending',
                'value' => 'Pending'
            ],
            1 => [
                'label' => 'Approve',
                'value' => 'Approve'
            ],
            2 => [
                'label' => 'Discard',
                'value' => 'Discard'
            ],
        ];

        return $options;
    }
}
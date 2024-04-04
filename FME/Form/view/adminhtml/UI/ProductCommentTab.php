<?php

namespace FME\Form\view\adminhtml\UI;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class ProductCommentTab extends AbstractModifier
{

    /**
     * Modify data
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Modify meta data
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        dd('hi');
        $meta = array_replace_recursive(
            $meta,
            [
                'comment_tab_container' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'fieldset',
                                'label' => __('Product Comments'),
                                'collapsible' => true,
                                'sortOrder' => 5,
                                'opened' => true,
                                'visible' => true
                            ]
                        ]
                    ],
                    'children' => [
                        'comment_tab_container' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'formElement' => 'container',
                                        'componentType' => 'container',
                                        'component' => 'Magento_Ui/js/form/components/html',
                                        'required' => false,
                                        'sortOrder' => 5,
                                        'content' => 'hello'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );

        return $meta;
    }
}

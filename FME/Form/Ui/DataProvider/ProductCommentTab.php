<?php

namespace FME\Form\Ui\DataProvider;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\View\LayoutFactory; // Import LayoutFactory

class ProductCommentTab extends AbstractModifier
{
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     */
    public function __construct(LayoutFactory $layoutFactory)
    {
        $this->layoutFactory = $layoutFactory;
    }
    
    /**
     * Modify data
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
                                'opened' => false,
                                'visible' => true
                            ]
                        ]
                    ],
                    'children' => [
                        'comment_tab_content' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'formElement' => 'container',
                                        'componentType' => 'container',
                                        'component' => 'Magento_Ui/js/form/components/html',
                                        'required' => false,
                                        'sortOrder' => 5,
                                        'content' => $this->getGridBlockHtml()
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

    /**
     * Get HTML for Grid block
     *
     * @return string
     */
    protected function getGridBlockHtml()
    {
        return $this->layoutFactory->create()->createBlock(\FME\Form\Block\Adminhtml\MyGrid::class)->toHtml();    
    }
}

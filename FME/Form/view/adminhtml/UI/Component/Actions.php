<?php

namespace FME\Form\view\adminhtml\UI\Component;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{

    protected const URL_PATH_EDIT = 'customroute/dashboard/edit';
    protected const URL_PATH_DELETE = 'customroute/dashboard/delete';

    protected $urlBuilder;
    protected $_escaper;

    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $HelloWorldFactory,
        UrlInterface $urlBuilder,
        \Magento\Framework\Escaper $_escaper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->_escaper=$_escaper;
        parent::__construct($context, $HelloWorldFactory, $components, $data);
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        //echo "hi";exit;
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {

                if (isset($item['entity_id'])) {
                    if (isset($item['entity_id'])) {
                        $item[$this->getData('name')] = [
                            'edit' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_PATH_EDIT,
                                    [
                                        'entity_id' => $item['entity_id'],
                                    ]
                                ),
                                'label' => __('Edit'),
                            ],
                            'delete' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_PATH_DELETE,
                                    [
                                        'entity_id' => $item['entity_id'],
                                    ]
                                ),
                                'label' => __('Delete'),
                                'confirm' => [
                                    'title' => __('Delete Record ?'),
                                    'message' => __('Are you sure you wan\'t to delete a record?'),
                                ],
                            ],
                        ];
                    }
                }
        }
    }
    
        return $dataSource;
    }
}
<?php

namespace FME\Form\view\adminhtml\UI\Component;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Approvals extends Column
{

    protected const URL_PATH_APPROVE = 'customroute/dashboard/approvecomment';
    protected const URL_PATH_REJECT = 'customroute/dashboard/refusecomment';

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
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {

                if (isset($item['entity_id'])) {                    //&& $item['status'] != 'Refused'
                    if (isset($item['entity_id'])) {
                        $item[$this->getData('name')] = [
                            'approve' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_PATH_APPROVE,
                                    [
                                        'entity_id' => $item['entity_id'],
                                    ]
                                ),
                                'label' => __('Approve'),
                                'confirm' => [
                                    'title' => __('Approve Comment ?'),
                                    'message' => __('Are you sure you wan\'t to approve this comment?'),
                                ],
                            ],
                            'reject' => [
                                'href' => $this->urlBuilder->getUrl(
                                    static::URL_PATH_REJECT,
                                    [
                                        'entity_id' => $item['entity_id'],
                                    ]
                                ),
                                'label' => __('Refuse.'),
                                'confirm' => [
                                    'title' => __('Reject Comment ?'),
                                    'message' => __('Are you sure you wan\'t to reject this comment?'),
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
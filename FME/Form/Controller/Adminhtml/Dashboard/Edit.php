<?php
namespace FME\Form\Controller\Adminhtml\Dashboard;

class Edit extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = [
                    'href' => $this->getContext()->getUrl('customroute/dashboard/edit', ['id' => $item['entity_id']]),
                    'label' => __('Edit'),
                ];
            }
        }
        return $dataSource;
    }
}

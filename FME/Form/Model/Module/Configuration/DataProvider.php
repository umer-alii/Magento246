<?php
namespace FME\Form\Model\Module\Config;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    protected function prepareUpdateUrl()
    {
        $this->data['config']['update_url'] = $this->urlBuilder->getUrl('module/config/update');
    }
}

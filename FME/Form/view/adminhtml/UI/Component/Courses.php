<?php
namespace FME\Form\view\adminhtml\UI\Component;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Ui\Component\Form\FieldFactory;
use Magento\Ui\Component\Form\Fieldset as BaseFieldset;

class Courses extends BaseFieldset
{
    /**
     * @var FieldFactory
     */
    private $fieldFactory;

    public function __construct(
        ContextInterface $context,
        FieldFactory $fieldFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
        $this->fieldFactory = $fieldFactory;
    }

    /**
     * Get components
     *
     * @return UiComponentInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getChildComponents()
    {
        $checkBoxes = [
            ['value' => 'Math', 'label' => __('Math')],
            ['value' => 'Science', 'label' => __('Science')],
            ['value' => 'History', 'label' => __('History')],
            ['value' => 'CS', 'label' => __('CS')]
        ];

        foreach ($checkBoxes as $checkBox) {
            $fields[] = [
                'label' => $checkBox['label'],
                'formElement' => 'checkbox',
                'value' => $checkBox['value'],
            ];
        }

        foreach ($fields as $k => $fieldConfig) {
            $fieldInstance = $this->fieldFactory->create();

            $name = $k;

            $fieldInstance->setData(
                [
                    'config' => $fieldConfig,
                    'name' => $name,
                ]
            );

            $fieldInstance->prepare();
            $this->addComponent($name, $fieldInstance);
        }

        // Set CSS class for the fieldset to style the checkboxes
        $this->setData('config', array_merge_recursive($this->getData('config'), [
            'additionalClasses' => 'checkbox-inline'
        ]));

        return parent::getChildComponents();
    }
}

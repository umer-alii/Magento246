<?php
namespace FME\Form\Model;

use Magento\Framework\Option\ArrayInterface;
use Magento\Email\Model\Template\Config;

class EmailTemplateSourceModel implements ArrayInterface
{
    private $emailTemplateConfig;
 
    public function __construct(Config $emailTemplateConfig)
    {
        $this->emailTemplateConfig = $emailTemplateConfig;
    }
 
    public function getEmailTemplateOptionArray()
    {
        return $this->emailTemplateConfig->getAvailableTemplates();
    }

    public function toOptionArray()
    {

        foreach($this->emailTemplateConfig->getAvailableTemplates() as $template) 
            {
                // dd($template);
                $options[] = ["value"=> $template['value'],"label"=> $template['label']];
            }

            // dd($options);
        return $options;
    }
}
    // public function toOptionArray()
    // {
    //     return [
    //         ['value' => 'template1', 'label' => __('Template 1')],
    //         ['value' => 'template2', 'label' => __('Template 2')],
    //         // Add more templates as needed
    //     ];
    // }
// }

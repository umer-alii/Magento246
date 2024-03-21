<?php

namespace FME\Form\Controller\Customer;


use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Show implements HttpGetActionInterface  {
    // Normal way of initilaizing the class object
    // private $pageFactory;
    // public function __construct (PageFactory $pageFactory){
    //     $this->pageFactory = $pageFactory;
    // }

    // Alternative shottened way
    public function __construct (private PageFactory $pageFactory){}
    public function execute(): Page {
        return $this->pageFactory->create();
    }
}


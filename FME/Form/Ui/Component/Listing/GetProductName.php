<?php
namespace FME\Form\Ui\Component\Listing;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;

class GetProductName extends AbstractRenderer
{
    protected $_productRepository;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function render(DataObject $row)
    {
        $productId = $row->getData($this->getColumn()->getIndex());
        try {
            $product = $this->_productRepository->getById($productId);
            return $product->getName();
        } catch (\Exception $e) {
            return __('Error: %1', $e->getMessage());
        }
    }
}

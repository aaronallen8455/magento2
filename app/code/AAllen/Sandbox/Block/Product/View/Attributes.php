<?php

namespace AAllen\Sandbox\Block\Product\View;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Attributes extends  \Magento\Catalog\Block\Product\View\Attributes
{
    protected $_productRepo;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        PriceCurrencyInterface $priceCurrency,
        ProductRepositoryInterface $productRepository,
        array $data = []
    )
    {
        $this->_productRepo = $productRepository;

        parent::__construct($context, $registry, $priceCurrency, $data);
    }

    public function setProductById($productId)
    {
        $this->_product = $this->_productRepo->getById($productId);

        return $this;
    }
}
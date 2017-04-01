<?php

namespace AAllen\Test\Plugin;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Result\Page;

class ProductLayout
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function beforeAddPageLayoutHandles(Page $subject, ...$args)
    {
        if (is_array($args) && count($args) == 1) {
            $params = $args[0];
            if (isset($params['sku'])) {

                $product = $this->productRepository->getById($params['id']);

                if ($product->getPageLayout() === '2columns-right') {
                    $subject->getLayout()->getUpdate()->removeHandle($subject->getDefaultLayoutHandle());
                    return [$params, 'catalog_product_custom'];
                }
            }
        }

        return $args;
    }
}
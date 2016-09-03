<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 9/1/2016
 * Time: 3:09 PM
 */

namespace AAllen\AddAttToCart\Plugin;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Quote\Model\Quote\Item;

class DefaultItem
{

    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    public function aroundGetItemData($subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);

        /** @var Product $product */
        //$product = $item->getProduct();

        $product = $this->productRepo->getById($item->getProduct()->getId());
        $attributes = $product->getAttributes();

        $atts = [
            "product_manufacturer" => $attributes['manufacturer']->getFrontend()->getValue($product),
            "product_part_number" => $attributes['color']->getFrontend()->getValue($product)
        ];

        return array_merge($data, $atts);
    }
}
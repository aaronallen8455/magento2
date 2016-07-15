<?php

namespace AAllen\QuickMenu\Plugin;

use Magento\Catalog\Model\Category;

class CatUrl
{
    public function aroundGetUrl(
        Category $subject,
        \Closure $proceed
    )
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $products */
        $products = $subject->getProductCollection();
        if ($subject->getProductCount() === 1) {
            $url = $products->getFirstItem()->getProductUrl();
            if (!empty($url)) {
                return $url;
            }
        }
        $result = $proceed();
        return $result;
    }
}
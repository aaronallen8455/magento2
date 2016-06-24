<?php

namespace AAllen\QuickMenu\Plugin;

class CatUrl
{
    public function aroundGetUrl(
        $subject,
        \Closure $proceed
    )
    {
        $products = $subject->getProductCollection();
        if ($subject->getProductCount() === 1) {
            $url = null;
            foreach ($products as $product) {
                $url = $product->getProductUrl();
            }
            if (!is_null($url))
                return $url;
        }
        $result = $proceed();
        return $result;
    }
}
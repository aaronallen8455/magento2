<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 7/12/2016
 * Time: 3:58 PM
 */

namespace AAllen\CompareQty\Plugin;


class AddToCartUrl
{
    public function afterGetAddToCartUrl ($subject, $url)
    {
        // insert quantity param
        return preg_replace('/(?=uenc)/', 'qty/1/', $url);
    }
}
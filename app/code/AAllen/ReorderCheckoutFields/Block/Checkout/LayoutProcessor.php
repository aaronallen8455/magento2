<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/25/2017
 * Time: 7:05 PM
 */

namespace AAllen\ReorderCheckoutFields\Block\Checkout;


use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;

class LayoutProcessor implements LayoutProcessorInterface
{

    public function process($jsLayout)
    {
        //if (isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        //    ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']
        //)) {
        //    $fields = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        //    ['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];
        //    foreach ($fields as &$field) {
        //        $field['config']['template'] = 'AAllen_ReorderCheckoutFields/form/field';
        //    }
        //}

        return $jsLayout;
    }
}
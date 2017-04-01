<?php
/**
 * Created by PhpStorm.
 * User: Aaron Allen
 * Date: 2/21/2017
 * Time: 5:40 AM
 */

namespace AAllen\ReorderCheckoutFields\Plugin;


class Reorder
{

    public function afterProcess($subject, $jsLayout)
    {
        foreach ($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                 ['payment']['children']['payments-list']['children'] as &$child)
        {
            if (isset($child['children']['form-fields'])) {
                $child['children']['form-fields']['children']['postcode'] = array_merge(
                    $child['children']['form-fields']['children']['postcode'],
                    ['sortOrder' => 75]
                );
            }
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']
        ['children']['street']['sortOrder'] = 200;

        //if (isset($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        //    ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']
        //)) {
        //    $fields = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        //    ['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];
//
        //    foreach ($fields as $name => &$field) {
        //        // street field uses different template than others
        //        if ($name === 'street') {
        //            //$field['config']['template'] = 'AAllen_ReorderCheckoutFields/group/group';
        //            //$field['sortOrder'] = 200;
        //        }
        //        else {
        //            //$field['config']['template'] = 'AAllen_ReorderCheckoutFields/form/field';
        //        }
        //    }
        //}

        return $jsLayout;
    }
}
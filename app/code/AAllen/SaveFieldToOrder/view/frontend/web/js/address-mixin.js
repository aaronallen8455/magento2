/**
 * Created by Aaron Allen on 6/8/2017.
 */
define([
    'mage/utils/wrapper', 
    'Magento_Checkout/js/model/quote'
], function (wrapper, quote) {
    'use strict';

    return function (setShippingInformation) {
        return wrapper.wrap(
            setShippingInformation, function (action) {
                var shippingAddress = quote.shippingAddress();

                if (shippingAddress['extension_attributes'] === undefined) {
                    shippingAddress['extension_attributes'] = {};
                }

                shippingAddress['extension_attributes']['custom'] = shippingAddress.customAttributes['custom'];

                return action();
            }
        );
    };
});
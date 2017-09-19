/**
 * Created by Aaron Allen on 8/15/2016.
 */
define([
    'Magento_Checkout/js/view/shipping',
    'ko'
], function (Shipping, ko) {
    'use strict';

    ko.bindingHandlers.customBinding = {
        // This will be called when the binding is first applied to an element
        init: function (element, valueAccesor) {
            console.log('I am a custom binding.');
        }
    };

    return Shipping.extend({
        defaults: {
            template: 'AAllen_KoBinding/shipping'
        }
    });
});
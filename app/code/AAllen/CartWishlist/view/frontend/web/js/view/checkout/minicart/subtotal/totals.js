/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (ko, Component, customerData) {
    'use strict';

    return Component.extend({
        displaySubtotal: ko.observable(true),

        /**
         * @override
         */
        initialize: function () {
            this._super();
            this.cart = customerData.get('cart');
            /*this.freeShiping = '';
            this.observe(['freeShipping']);

            this.cart.subscribe(function (newValue) {
                window.alert(newValue.subtotal);
            });*/
        }
    });
});
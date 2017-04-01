/**
 * Created by Aaron Allen on 3/26/2017.
 */
define([
    'uiRegistry',
    'uiComponent',
    'ko'
], function (registry, Component, ko) {
    'use strict';

    const FIELDS = 'checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset';

    return Component.extend({
        defaults: {
            template: 'AAllen_CheckoutCheckbox/summary/special',
            imports: {
                update: 'checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.country_id:value'
            }
        },

        initialize: function () {
            this._super();
        },

        update: function (value) {

            //var country = registry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.country_id');

            this.text(value);
        },

        text: ko.observable()
    })
});
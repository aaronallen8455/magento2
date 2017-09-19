/**
 * Created by Aaron Allen on 3/26/2017.
 */
define([
    'uiRegistry',
    'Magento_Ui/js/form/element/abstract',
    'ko'
], function (registry, Component, ko) {
    'use strict';

    const FIELDS = 'checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset';

    return Component.extend({
        defaults: {
            template: 'AAllen_CheckoutCheckbox/summary/special',
            imports: {
                update: '$ { $.parentName }.country_id:value'//'checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.country_id:value'
            }
        },

        initialize: function () {
            this._super();

            //console.log(this.visible);
            //this.visible(false);
        },

        update: function (value) {

            //var country = registry.get('checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.country_id');

            //console.log(value);
            //console.log('test');
            //if (value === 'NL') {
            //    console.log('test');
            //    this.hide();
            //}
            this.visible(value !== 'NL');
            this.text(value);
        },

        text: ko.observable()
    })
});
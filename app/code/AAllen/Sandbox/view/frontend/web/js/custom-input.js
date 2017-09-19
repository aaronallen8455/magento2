/**
 * Created by Aaron Allen on 4/30/2017.
 */
define([
    'Magento_Ui/js/form/element/abstract',
    'uiRegistry'
], function (Component, registry) {
    'use strict';

    return Component.extend({
        defaults: {
            imports: {
                update: '${ $.parentName }.country_id:value'//'checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.country_id:value'
            }
        },

        initialize: function () {
            this._super();
            _registery = registry;
        },

        update: function (value) {
            this.visible(value !== 'NL');
        }
    });
});

var _registery;
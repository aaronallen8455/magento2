/**
 * Created by Aaron Allen on 3/27/2017.
 */
define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'ko',
        'Magento_Checkout/js/model/totals',
        'AAllen_CheckoutCheckbox/js/view/checkout/billing/checkbox',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/customer-data'
    ],
    function ($, Component, ko, totals, checkbox, quote, customerData) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'AAllen_CheckoutCheckbox/summary/giftwrap'
                //imports: {
                //    update: 'checkout.steps.billing-step.payment.afterMethods.giftwrap:value'
                //}
            },

            totals: quote.getTotals(),

            //update: function (value) {
            //    this.isVisible(value);
            //},

            isDisplayed: function() {
                return this.isFullMode() && this.getPureValue() !== 0;
            },

            getPureValue: function () {
                var value = 0,
                    total;
                if (total = totals.getSegment('giftwrap')) {
                    value =  total.value;
                }

                return value;
            },

            getValue: function() {
                return this.getFormattedPrice(this.getPureValue());
            }
        });
    }
);
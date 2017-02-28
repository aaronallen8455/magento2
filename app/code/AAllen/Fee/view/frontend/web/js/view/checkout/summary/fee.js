/**
 * Created by Aaron Allen on 11/27/2016.
 */
define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals'
], function (Component, quote, priceUtils, totals) {
    'use strict';

    return Component.extend({
        defaults: {
            //isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
            template: 'AAllen_Fee/checkout/summary/fee'
        },

        totals: quote.getTotals(),

        isFeeDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,

        isDisplayed: function () {
            return this.isFullMode();
        },

        getValue: function () {
            console.log(totals.getSegment('fee'));
            var price = 0;
            if (this.totals()) {
                price = totals.getSegment('fee').value;
            }
            return this.getFormattedPrice(price);
        },

        isCalculated: function() {
            return this.totals() && this.isFullMode() && null != totals.getSegment('fee');
        },

        getBaseValue: function () {
            var price = 0;
            if (this.totals()) {
                price = this.totals().base_fee;
            }
            return priceUtils.formatPrice(price, quote.getBasePriceFormat());
        }
    })
});
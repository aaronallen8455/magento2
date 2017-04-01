/**
 * Created by Aaron Allen on 3/28/2017.
 */
define([
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'Magento_Checkout/js/model/full-screen-loader',
    'Magento_Checkout/js/model/quote',
    'mage/storage',
    'Magento_Checkout/js/action/get-payment-information',
    'Magento_Checkout/js/model/totals',
    'Magento_Checkout/js/model/error-processor',
    'Magento_SalesRule/js/model/payment/discount-messages',
    'Magento_Checkout/js/model/resource-url-manager'
], function ($, Component, fullScreenLoader, quote, storage, getPaymentInformationAction, totals, errorProcessor, messageContainer, urlManager) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            this.value(totals.getSegment('giftwrap') !== 0);
            this.value.subscribe(this.toggle.bind(this));
        },
        toggle: function (value) {
            // call to the giftwrap api
            var url = this.getApplyGiftwrapUrl(value, quote.getQuoteId());
            fullScreenLoader.startLoader();

            return storage.put(
                url,
                {},
                false
            ).done(
                function (response) {
                    if (response) {
                        var deferred = $.Deferred();

                        totals.isLoading(true);
                        getPaymentInformationAction(deferred);
                        $.when(deferred).done(function () {
                            fullScreenLoader.stopLoader();
                            totals.isLoading(false);
                        });
                        //messageContainer.addSuccessMessage({
                        //    'message': 'YEAH!'
                        //});
                    }
                }
            ).fail(
                function (response) {
                    fullScreenLoader.stopLoader();
                    totals.isLoading(false);
                    errorProcessor.process(response, messageContainer);
                }
            );
        },

        getApplyGiftwrapUrl: function(giftWrapped, quoteId) {
            var params = {quoteId: quoteId};
            var urls = {
                'guest': '/guest-carts/' + quoteId + '/giftwrap/' + giftWrapped,
                'customer': '/guest-carts/' + quoteId + '/giftwrap/' + giftWrapped
            };
            return urlManager.getUrl(urls, params);
        }
    })
});
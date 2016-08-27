/**
 * Created by Aaron Allen on 8/27/2016.
 */
define([
    'jquery',
    'mage/mage',
    'Magento_Catalog/product/view/validation',
    'Magento_Catalog/js/catalog-add-to-cart'
], function ($) {
    "use strict";

    return function (config, element) {
        //$(element).click(function (e) {

            // add 'buy now' flag to form
            //form.append(
            //    $('<input type="hidden" name="buy-now" value="1">')
            //);
            //// change form action
            //var url = form.attr('action').replace('checkout/cart/add', 'buynow/cart/add');
            //form.attr('action', url);

            //return false;

        $(element).click(function () {
            var form = $(config.form),
                widget = form.catalogAddToCart({
                bindSubmit: false
            });

            // add 'buy now' flag to form
            form.append(
                $('<input type="hidden" name="buy-now" value="1">')
            );
            // change form action
            var url = form.attr('action').replace('checkout/cart/add', 'buynow/cart/add');
            form.attr('action', url);

            widget.catalogAddToCart('submitForm', form);
            //todo: set back to defaults

            return false;
        });




            //return false;
        //});
    }
});

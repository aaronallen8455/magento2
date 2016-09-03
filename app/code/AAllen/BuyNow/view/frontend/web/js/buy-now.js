
define([
    'jquery',
    'mage/mage',
    'Magento_Catalog/product/view/validation',
    'Magento_Catalog/js/catalog-add-to-cart'
], function ($) {
    "use strict";

    return function (config, element) {

        $(element).click(function () {
            var form = $(config.form),
                widget = form.catalogAddToCart({
                bindSubmit: false
            });

            // change form action
            var baseUrl = form.attr('action'),
                buyNowUrl = baseUrl.replace('checkout/cart/add', 'buynow/cart/add');

            form.attr('action', buyNowUrl);

            widget.catalogAddToCart('submitForm', form);

            // set form action back
            form.attr('action', baseUrl);

            return false;
        });
    }
});

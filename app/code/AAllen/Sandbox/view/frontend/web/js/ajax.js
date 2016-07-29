/**
 * Created by Aaron Allen on 7/27/2016.
 */
define([
    'jquery',
    'loaderAjax'
],
    function ($) {
        'use strict';

        return function (config, elem) {
            elem.onchange = function () {
                $(elem).trigger('ajaxSend');
                $.ajax('/sandbox/', {
                    showLoader: true,
                    context: config.contentDiv,
                    method: 'post',
                    data: {
                        category_id: elem.value
                    },
                    success: function (response) {
                        $(config.contentDiv).html(response);
                    }
                });
            };
        };
    }
);
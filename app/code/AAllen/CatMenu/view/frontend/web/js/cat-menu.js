/**
 * Created by Aaron Allen on 7/29/2016.
 */

define([
    'jquery'
    ],
    function ($) {
        'use strict';

        return function (config, elem) {
            $(elem).click(function (e) {

                window.history.replaceState({}, '', '/?cat=' + config.categoryId);

                $.ajax('/cat_menu/', {
                    showLoader: true,
                    context: config.contentDiv,
                    method: 'post',
                    data: {
                        category_id: config.categoryId
                    },
                    success: function (response) {
                        $(config.contentDiv).html(response);
                    }
                });
            })
        };
    }
);
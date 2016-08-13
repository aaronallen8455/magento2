/**
 * Created by Aaron Allen on 7/29/2016.
 */

define([
    'jquery'
    ],
    function ($) {
        'use strict';

        // cache html in this variable
        var html = [];

        return function (config, elem) {

            // cache the default tab
            if (config.defaultTab.id)
                html[config.defaultTab.id] = $(config.contentDiv).html();

            $(elem).click(function (e) {

                // add the tab number to the url for redirect purposes
                window.history.replaceState({}, '', '/?tab=' + config.tabIndex);

                if (!html[config.tabIndex]) {
                    // get the content
                    $.ajax('/showcase_ajax/', {
                        showLoader: true,
                        context: config.contentDiv,
                        method: 'post',
                        data: {
                            conditions: config.conditions
                        },
                        success: function (response) {
                            html[config.tabIndex] = response;
                            $(config.contentDiv).html(response);
                        }
                    });
                }else
                    $(config.contentDiv).html(html[config.tabIndex]);
            });
        };
    }
);
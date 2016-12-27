/**
 * Created by Aaron Allen on 9/6/2016.
 */
define([
    'jquery'
], function ($) {
    'use strict';

    return function (config) {
        $(config.links + ' a').click(function () {
            var index = this.dataset.index;
            window.scroll(
                window.scrollX,
                $(config.answers + ' dt[data-index="' + index + '"]').offset().top
            );

            return false;
        })
    }
});
/**
 * Created by Aaron Allen on 6/23/2016.
 */
define([
    'jquery'
], function ($) {
    'use strict';
    return function (config, elem) {
        var loadingGif = new Image();
        loadingGif.src = config.loaderUrl;
        elem.appendChild(loadingGif);
        $.ajax('/aallen_randomblock/action/render', {
            method: 'post',
            data: {
                ids: config.ids,
                num: config.num
            },
            success: function (response) {
                loadingGif.remove();
                elem.innerHTML = response;
            }
        });
    };
});
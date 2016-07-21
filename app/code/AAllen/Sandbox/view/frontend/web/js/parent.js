/**
 * Created by Aaron Allen on 7/16/2016.
 */
define([
    'jquery',
    'uiClass'
    ],
function ($, Class) {
    'use strict';

    return Class.extend({
        initialize: function (config, element) {
            this._super();

            $(element).html(config.test);

            this.method();
        },
        method: function () {
            window.alert('method!');
        }
    });
});
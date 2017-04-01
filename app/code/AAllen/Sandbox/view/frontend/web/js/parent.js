/**
 * Created by Aaron Allen on 7/16/2016.
 */
define([
    'jquery',
    'uiClass'
    ],
function ($, Class) {
    'use strict';

    var v;

    return Class.extend({
        initialize: function (config, element) {
            this._super();

            this.someValue = config.test;
            v = config.test;

            $(element).html(config.test);

            this.method();
        },
        method: function () {
            window.alert('method!');
        },
        getV: function () {
            return v;
        },
        someValue: null
    });
});
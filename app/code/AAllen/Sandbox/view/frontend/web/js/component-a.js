/**
 * Created by Aaron Allen on 1/21/2018.
 */

define([
    'ko',
    'jquery',
    'uiComponent',
    'AAllen_Sandbox/js/component-singleton'
], function (ko, $, Component, Singleton) {

    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();

            Singleton.data.push('A');
            console.log(Singleton.data);
        },

        data: "my name is A"
    });
});
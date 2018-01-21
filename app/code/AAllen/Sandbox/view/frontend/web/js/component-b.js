/**
 * Created by Aaron Allen on 1/21/2018.
 */
define([
    'ko',
    'jquery',
    'uiComponent',
    'AAllen_Sandbox/js/component-singleton',
    'AAllen_Sandbox/js/component-a'
], function (ko, $, Component, Singleton, CompA) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();

            Singleton.data.push('B');
            console.log(Singleton.data);
            console.log(new CompA().data);
        },

        data: 'my name is B'
    });
});
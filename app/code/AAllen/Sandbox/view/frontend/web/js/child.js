/**
 * Created by Aaron Allen on 7/16/2016.
 */

define([
    'parent'
], function (Parent) {
    'use strict';

    return Parent.extend({
        initialize: function (config, element) {
            this._super();


            element.style.backgroundColor = 'blue';
            element.style.color = 'white';
        },
        method: function () {
            window.alert(this.someValue);
        }
    });
});
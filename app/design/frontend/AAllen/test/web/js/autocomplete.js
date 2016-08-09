/**
 * Created by Aaron Allen on 8/4/2016.
 */
define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    //return Class.extend({
    //    initialize: function () {
    //        this._super();
    //        $('#checkout').on('keyup', this.keyUpHandler);
    //    },
//
    //    keyUpHandler: function (e) {
    //        if (e.target.getAttribute('type') === 'text') {
    //            console.log('test');
    //        }
    //    },
//
    //    initContainer: function () {
//
    //    }
    //});

    $.widget('mage.checkoutAutocomplete', {

        keyUpHandler: function (e) {
            if (e.target.getAttribute('type') === 'text') {
                console.log('test');
            }
        },

        initContainer: function () {

            $('#checkout').on('keyup', this.keyUpHandler);
        }
    });

    return $.mage.checkoutAutocomplete;
});
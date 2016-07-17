/**
 * Created by Aaron Allen on 7/16/2016.
 */

define([
    'mage/gallery/gallery'
], function (gallery) {
    'use strict';

    gallery.prototype.initialize = function () {
        gallery.constructor.initialize();
    };

    return function (config, element) {
        console.log(gallery.prototype.initialize);
    }
});
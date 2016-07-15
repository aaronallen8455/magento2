/**
 * Created by Aaron Allen on 7/9/2016.
 */

define([
    'jquery',
    'alib'
], function ($, lib) {
    'use strict';
    
    return function (config) {
        console.log(config);
        lib.func(config.var1);
    }
});
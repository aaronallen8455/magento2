define([
    'mage/utils/wrapper'
], function (wrapper) {
    'use strict';

    return function (Form) {

        return Form.extend({

            initialize: function () {
                this._super();
                console.log('TESTINGTESTING!!!');
            }
        });
    }
});
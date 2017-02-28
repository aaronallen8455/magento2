define([
    'mage/utils/wrapper'
], function (wrapper) {
    'use strict';

    return function (Form) {

        return Form.extend({

            initialize: function () {
                console.log('TESTINGTESTING222!!!');
                this._super();
            }
        });
    }
});
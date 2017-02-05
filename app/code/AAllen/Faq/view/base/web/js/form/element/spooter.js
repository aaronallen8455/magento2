define([
    'Magento_Ui/js/form/element/abstract'
], function (AbstractElement) {
    'use strict';

    return AbstractElement.extend({
        defaults: {
            elementTmpl: 'AAllen_Faq/form/spooter'
        },

        initialize: function () {
            this._super();

            this.hours = '00';
            this.minutes = '00';

            this.observe(['hours', 'minutes']);

            var value = this.value();

            this.hours(value.slice(0,2));
            this.minutes(value.slice(2));
        },

        userChanges: function () {
            this._super();

            this.value(this.hours() + this.minutes());
        },

        hoursOpts: (function () {
            var opts = [];

            for (var i=0; i<24; i++) {
                opts.push({
                    label: i.toString(),
                    value: ('00' + i).slice(-2)
                })
            }

            return opts;
        })(),

        minutesOpts: (function () {
            var opts = [];

            for (var i=1; i<=60; i++) {
                opts.push({
                    label: i.toString(),
                    value: ('00' + i).slice(-2)
                })
            }

            return opts;
        })()
    });
});
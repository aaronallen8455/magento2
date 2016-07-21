/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'mage/gallery/gallery'
], function ($, Gallery) {
    'use strict';

    return Gallery.extend({

        /**
         * Initializes gallery.
         * @param {Object} config - Gallery configuration.
         * @param {String} element - String selector of gallery DOM element.
         */
        initialize: function (config, element) {
            var self = this;

            this._super();

            $(config.videoLink).click(function (e) {
                self.settings.api.last();
            });
        }
    });
});

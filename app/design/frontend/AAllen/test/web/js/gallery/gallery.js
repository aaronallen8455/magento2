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

        initFullscreenSettings: function () {
            var settings = this.settings,
                self = this;

            this._super();

            settings.$gallery.on('fotorama:fullscreenexit', function () {
                settings.closeIcon.hide();
                settings.focusableStart.attr('tabindex', '-1');
                settings.focusableEnd.attr('tabindex', '-1');
                settings.api.updateOptions(settings.defaultConfig.options, true);
                settings.focusableStart.unbind('focusin', this._focusSwitcher);
                settings.focusableEnd.unbind('focusin', this._focusSwitcher);
                settings.closeIcon.hide();

                if (!_.isEqual(settings.activeBreakpoint, {}) && settings.breakpoints) {
                    settings.api.updateOptions(settings.activeBreakpoint.options, true);
                }
                settings.isFullscreen = false;
                settings.$element.data('gallery').updateOptions({
                    swipe: true
                });

                self.settings.api.first();
            });
        },

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

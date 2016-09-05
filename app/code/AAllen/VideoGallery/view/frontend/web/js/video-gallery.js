/**
 * Created by Aaron Allen on 9/4/2016.
 */
define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    var apiRegistered = false,
        player = null; // the YT player object

    $.widget('aa.videoGallery', {
        _create: function () {
            var self = this;
            this._loadApi();

            // click handler for changing video
            this.element.click(function () {
                if (player && player.getVideoEmbedCode() != self.element.data('code')) {
                    self.loadVideo();
                }

                return false;
            })
        },

        _loadApi: function () {
            var self = this;

            // if YT api is already created, do nothing
            if (apiRegistered) return;
            apiRegistered = true;

            var element = document.createElement('script'),
                scriptTag = document.getElementsByTagName('script')[0];

            element.async = true;
            element.src = 'https://www.youtube.com/iframe_api';
            scriptTag.parentNode.insertBefore(element, scriptTag);

            /**
             * Trigger youtube api ready event
             */
            window.onYouTubeIframeAPIReady = function () {
                self._createPlayer();
            };
        },

        _createPlayer: function () {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                videoId: this.element.data('code')
            });
        },

        loadVideo: function () {
            var self = this;
            player.cueVideoById({
                videoId: self.element.data('code')
            });
        }
    });

    return $.aa.videoGallery;
});
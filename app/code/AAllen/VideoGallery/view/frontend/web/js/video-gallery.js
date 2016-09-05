/**
 * Created by Aaron Allen on 9/4/2016.
 */
define([
    'jquery',
    'jquery/ui',
    'loader'
], function ($) {
    'use strict';

    var apiRegistered = false,
        apiReady = false,
        playerReady = false,
        player = null; // the YT player object

    $.widget('aa.videoGallery', {
        _create: function () {
            this._loadApi();
            this._initElements();
        },

        _initElements: function () {
            var self = this,
                elements = this.element.find('a');

            // click handler for changing video
            elements.click(function () {
                if (
                    apiReady &&
                    this.dataset.vendor === 'youtube' //&&
                ) {
                    self.loadVideo(this.dataset.code);
                }

                return false;
            });
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
                apiReady = true;
            };
        },

        _createPlayer: function (code) {
            $('#player').trigger('processStart'); // show loading gif

            player = new YT.Player('player', {
                height: '390',
                width: '640',
                videoId: code,
                events: {
                    'onReady': this.onPlayerReady.bind(this, code)
                }
            });
        },

        onPlayerReady: function (code) {
            $('#player').trigger('processStop'); // end loading gif
            playerReady = true;
            this.loadVideo(code);
        },

        loadVideo: function (code) {
            // if no player, create it and play when player is ready
            if (!player) {
                this._createPlayer(code);
            } else if (playerReady) {
                player.loadVideoById({
                    videoId: code
                });
            }
        }
    });

    return $.aa.videoGallery;
});
define([
    'jquery',
    'uiClass'
], function ($, Class) {
    'use strict';

    return Class.extend({
        initialize: function (config, elem) {
            this._super();

            this.images = config.images;
            this.duration = config.duration;
            this.imageElement = $(elem).children('img');
            this.container = $(elem);

            // attach interval
            window.setInterval(this.nextImage.bind(this), this.duration * 1000);
        },

        nextImage: function () {
            var newImage = $('<img>')
                .attr('src', this.getNextSource())
                .css({maxWidth: this.container.innerWidth(), maxHeight: this.container.innerHeight()})
                .appendTo(this.container);

            this.imageElement.css(
                {
                    position: 'absolute',
                    marginLeft: (newImage.outerWidth() - this.imageElement.outerWidth())/2
                }).fadeOut(2000, function () {
                this.imageElement.remove();
                this.imageElement = newImage;
            }.bind(this));
        },

        getNextSource: function () {
            this.currentIndex++;
            if (this.currentIndex == this.images.length) this.currentIndex = 0;

            return this.images[this.currentIndex];
        },

        currentIndex: 0
    })
});
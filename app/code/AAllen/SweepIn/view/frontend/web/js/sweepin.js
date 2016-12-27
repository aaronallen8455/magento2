/**
 * Created by Aaron Allen on 12/26/2016.
 */
define([
    'jquery'
], function ($) {
    'use strict';

    var elements = [], // collection of all sweep-in elements
        win = $(window);
        //overflow, // used to reset the parent element to previous overflow value
        //procRunning = 0;

    function scrollHandler (e) {
        var queued = elements[0];

        if (queued && win.scrollTop() + win.height() >= queued.element.offset().top + queued.element.height()) {
            elements.shift();

            if (elements[0] && elements[0].element.offset().top === queued.element.offset().top)
                scrollHandler(); // do adjacent elements

            var prop,
                amount;
            switch (queued.direction) {
                case 'left':
                    prop = 'left';
                    amount = 100;
                    break;
                case 'right':
                    prop = 'left';
                    amount = -100;
                    break;
                case 'up':
                    prop = 'top';
                    amount = 100;
                    break;
                case 'down':
                    prop = 'top';
                    amount = -100;
            }

            // get to starting position
            queued.element.css(prop, amount);

            //if (!overflow) overflow = queued.element.parent().css('overflow-x');
            //queued.element.parent().css('overflow-x', 'hidden');
            // do animation
            //procRunning++;
            var obj = prop === 'left' ?
                {
                    left: 0,
                    opacity: 1
                } :
                {
                    top: 0,
                    opacity: 1
                };
            queued.element.animate(
                obj,
                750,
                'easeOutQuart'//,
                //function () {
                //    if (--procRunning === 0) {
                //        queued.element.parent().css('overflow-x', overflow); // reset overflow afterwards
                //    }
                //}
            );

            // remove handler if no more elements
            if (elements.length === 0) {
                win.off('scroll', scrollHandler);
            }
        }
    }

    var handleAttached = false;

    return function (config, element) {
        var el = $(element);

        elements.push({
            element: el,
            direction: config ? config.direction : 'left'
        });

        // sort elements
        elements.sort(function (a, b) {
            return a.element.offset().top - b.element.offset().top;
        });

        // make element relative positioned and hidden
        el.css({position: 'relative', opacity: 0});

        // register handler
        if (!handleAttached) { // only attach one handler for all elements
            handleAttached = true;
            win.on('scroll', scrollHandler);
        }
    }
});
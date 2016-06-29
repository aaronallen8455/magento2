/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    "jquery",
    "jquery/ui",
    "jquery/jquery.mobile.custom",
    "mage/translate"
], function ($) {
    'use strict';

    /**
     * Menu Widget - this widget is a wrapper for the jQuery UI Menu
     */
    $.widget('aaron.menu', $.mage.menu, {
        options: {
            responsive: false,
            expanded: false,
            delay: 0
        },

        _toggleDesktopMode: function () {
            this._on({
                // Prevent focus from sticking to links inside menu after clicking
                // them (focus should always stay on UL during navigation).
                "mousedown .ui-menu-item > a": function (event) {
                    event.preventDefault();
                },
                "click .ui-state-disabled > a": function (event) {
                    event.preventDefault();
                },
                "click .ui-menu-item:has(a)": function (event) {
                    var target = $(event.target).closest(".ui-menu-item");
                    if (!this.mouseHandled && target.not(".ui-state-disabled").length) {
                        this.select(event);

                        // Only set the mouseHandled flag if the event will bubble, see #9469.
                        if (!event.isPropagationStopped()) {
                            this.mouseHandled = true;
                        }

                        // Open submenu on click
                        if (target.has(".ui-menu").length) {
                            this.expand(event);
                        } else if (!this.element.is(":focus") && $(this.document[0].activeElement).closest(".ui-menu").length) {

                            // Redirect focus to the menu
                            this.element.trigger("focus", [true]);

                            // If the active item is on the top level, let it stay active.
                            // Otherwise, blur the active item since it is no longer visible.
                            if (this.active && this.active.parents(".ui-menu").length === 1) {
                                clearTimeout(this.timer);
                            }
                        }
                    }
                },
                "mouseenter .ui-menu-item": function (event) {
                    var target = $(event.currentTarget),
                        ulElement,
                        ulElementWidth,
                        width,
                        targetPageX,
                        rightBound = $(window).width();

                    if (target.has('ul')) {
                        ulElement = target.find('ul');

                        if (rightBound >= 768) {
                            // drop down or slide right animation
                            if (ulElement[0] && ulElement[0].classList.contains('level0')) {
                                $(ulElement[0]).slideDown().children('li').css({marginBottom:0, height:0}).animate({marginBottom:'1rem', height:35});
                            }else{
                                var ele = $(ulElement[0]),
                                    CssMinWidth = ele.css('minWidth');
                                ele.css({whiteSpace:'nowrap', minWidth:0, width:0}).animate({minWidth:CssMinWidth, width:'100%'});
                            }
                        }

                        ulElementWidth = target.find('ul').outerWidth(true);
                        width = target.outerWidth() * 2;
                        targetPageX = target.offset().left;

                        if ((ulElementWidth + width + targetPageX) > rightBound) {
                            ulElement.addClass('submenu-reverse');
                        }
                        if ((targetPageX - ulElementWidth) < 0) {
                            ulElement.removeClass('submenu-reverse');
                        }
                    }

                    // Remove ui-state-active class from siblings of the newly focused menu item
                    // to avoid a jump caused by adjacent elements both having a class with a border
                    target.siblings().children(".ui-state-active").removeClass("ui-state-active");
                    this.focus(event, target);
                },
                "mouseleave": function (event) {
                    this.collapseAll(event, true);
                },
                "mouseleave .ui-menu": "collapseAll"
            });

            var categoryParent = this.element.find('.all-category'),
                html = $('html');

            categoryParent.remove();

            if (html.hasClass('nav-open')) {
                html.removeClass('nav-open');
                setTimeout(function () {
                    html.removeClass('nav-before-open');
                }, 300);
            }
        },
        _delay: function(handler, delay) {
            var instance = this,
                handlerProxy = function () {
                return (typeof handler === "string" ? instance[handler] : handler)
                    .apply(instance, arguments);
            };

            return setTimeout(handlerProxy, delay || 0);
        }
    });

    return $.aaron.menu;
});

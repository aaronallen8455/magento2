/**
 * Created by Aaron Allen on 7/18/2016.
 */

define([
    "jquery",
    "jquery/ui",
    "jquery/jquery.mobile.custom",
    "mage/menu"
], function ($) {

    $.widget('mage.menux', $.mage.menu, {
        _toggleDesktopMode: function () {
            //holds the timeOut for animations
            var timeOut;

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

                        // don't animate mobile version or elements that are already displaying.
                        if (this.options.toggle && rightBound >= 768 && ulElement[0] && ulElement[0].style.display === 'none') {

                            var delay = this.options.delay,
                                ele = $(ulElement[0]),
                                speed = this.options.speed;

                            // drop down or slide right animation
                            if (ulElement[0].classList.contains('level0')) {

                                timeOut = window.setTimeout(
                                    function () {
                                        ele.slideDown(speed);

                                        // animate each li based on its offset height
                                        ele.children('li').each(function () {
                                            var cssHeight = this.offsetHeight;
                                            $(this).css(
                                                {
                                                    marginBottom:0,
                                                    height:0
                                                }
                                            ).animate(
                                                {
                                                    marginBottom:'1rem',
                                                    height:cssHeight
                                                }, speed
                                            )
                                        });
                                    }, delay);
                            }else{
                                var cssMinWidth = ele.css('minWidth'),
                                    cssTop = event.currentTarget.offsetTop + 6;
                                // store the width on the element
                                if (!ele.data('real-width')) {
                                    var clone = ele.clone().css({width: 'auto', minWidth: 0}).appendTo('body');
                                    ele.data('real-width', parseInt(clone.css('width').slice(0,-2)) + 45 + 'px');
                                    clone.remove();
                                }

                                timeOut = window.setTimeout(
                                    function () {
                                        ele.css(
                                            {
                                                whiteSpace:'nowrap',
                                                minWidth:0,
                                                width:0,
                                                top: cssTop
                                            }
                                        ).animate(
                                            {
                                                minWidth:cssMinWidth,
                                                width: ele.data('real-width'),
                                                top: cssTop // hold correct vertical position
                                            }, speed
                                        );
                                        ele.children('li').css(
                                            {
                                                marginBottom: 0,
                                                height: 0
                                            }
                                        ).animate(
                                            {
                                                marginBottom: '1rem',
                                                height: 35
                                            }, speed
                                        );
                                    }, delay);

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
                "mouseleave .ui-menu": "collapseAll",
                "mouseleave .ui-menu-item.level0": function () {
                    //cancel timeOut to prevent animation on inactive elements
                    window.clearTimeout(timeOut);
                },
                "mouseup .ui-menu-item": function (event) {
                    var target = $(event.currentTarget);
                    target.find('ul')[0].style.visibility = 'hidden';
                    event.cancelBubble();
                }
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
        }
    });

    return {
        menu: $.mage.menux,
        navigation: $.mage.navigation
    };
});
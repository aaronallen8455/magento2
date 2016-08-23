/**
 * Created by Aaron Allen on 8/20/2016.
 */
define([
    'jquery',
    'uiClass'
], function ($, Class) {
    'use strict';

    return Class.extend({
        initialize: function (config, element) {
            this._initMenu(config.menu);
            this.element = $(element).css({position: 'relative', overflow: 'hidden'});
            this.draw(config.menu['Default Category'], 'none'); // show the root category
            this._super();
        },

        // add method to get parent for each category object and set category name
        _initMenu: function (menu) {
            for (var key in menu) {
                if (!menu.hasOwnProperty(key)) continue;

                if (typeof menu[key] === 'object') {
                    menu[key].parent = function () {
                        return menu;
                    };

                    if (menu.name) {
                        menu[key].name = menu.name + ' > ' + key;
                    }else menu[key].name = 'Products'; // title for root category

                    this._initMenu(menu[key]);
                }
            }
        },

        // draw a category
        draw : function (category, direction) {
            var self = this;

            var prevDiv = null;
            if (prevDiv = this.element.children().first()) {
                // slide left
                prevDiv.animate({left: prevDiv.width() * (direction === 'forward'?-1:1)}, this.duration, function () {this.remove();});
            }

            var container = $('<div>'); // div that holds the menu elements

            $('<h3>').html(category.name).appendTo(container); // title

            // add back button if not top level
            if (category.parent().parent) {

                var back = $('<a href="#">')
                    .click(bindToLink.bind(this, category.parent(), 'back'))
                    .text('Back');

                container.append(back);
            }

            var linkList = $('<ul>').appendTo(container);

            // create links
            for (var key in category) {
                if (!category.hasOwnProperty(key) || key === 'parent' || key === 'name') continue;

                var link;

                if (typeof category[key] === 'object') { // open child category
                    link = $('<a href="#">').click(bindToLink.bind(this, category[key], 'forward')).text(key);
                } else if (typeof category[key] === 'string') { // product link
                    link = $('<a>').attr('href', category[key]).text(key);
                }

                $('<li>').append(link).appendTo(linkList); // list item
            }

            // the link click handler
            function bindToLink(category, direction, e) {
                e.preventDefault();

                self.draw(category, direction);

                return false;
            }


            this.element.append(container);
            if (direction === 'none') {
                container.css({position: 'absolute', width: this.element.width()});
            } else {
                container.css({
                    position: 'absolute',
                    left: container.width() * (direction === 'forward'?1:-1),
                    width: this.element.width()
                }).animate({left: 0}, this.duration);
            }


            this.element.css('height', container.height());
        },

        element : null,

        duration : 250 // duration of animations
    });

});
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
            this.element = $(element);
            this.draw(config.menu['Default Category']); // show the root category
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
        draw : function (category) {
            var self = this;

            this.element.empty();

            var container = $('<div>');

            $('<h3>').html(category.name).appendTo(container); // title

            // add back button if not top level
            if (!category.parent().parent) {
                var back = $('<a href="#">').click(function (e) {
                    e.preventDefault();

                    self.draw(category.parent());

                    return false;
                }).text('Back');

                container.append(back);
            }

            var linkList = $('<ul>').appendTo(container);

            // create links
            for (var key in category) {
                if (!category.hasOwnProperty(key) || category.call || key === 'name') continue;

                var link;

                if (typeof category[key] === 'object') { // open child category

                    link = $('<a href="#">').click(bindToLink.bind(this, category[key])).text(key);
                    //listItem.append(link).appendTo(linkList);
                } else if (typeof category[key] === 'string') { // product link

                    link = $('<a>').attr('href', category[key]).text(key);
                    //listItem.append(productLink).appendTo(linkList);
                }

                $('<li>').append(link).appendTo(linkList); // list item
            }

            // the link click handler
            function bindToLink(category, e) {
                e.preventDefault();

                self.draw(category);

                return false;
            }

            this.element.append(container);
        },

        element : null
    });

});
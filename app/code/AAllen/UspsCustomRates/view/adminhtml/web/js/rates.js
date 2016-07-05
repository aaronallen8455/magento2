/**
 * Created by Aaron Allen on 7/4/2016.
 */

define([
    'jquery'
], function ($) {
    "use strict";

    var methodSelectors = [],
        priceInputs = [];

    return function (config, element) {
        // get the methods
        var methods = JSON.parse(decodeURIComponent(config.methods)),
            valueElement = $(config.value);

        // parse method names
        methods.each(function (x) {
            x.label = x.label.replace(/\+/g, ' ');
        });

        buildExistingRules(config.rules, element, methods, valueElement);

        // new rule button
        $(config.button).click(function () {
            $(element).append(createNewRule(null, null, methods, valueElement));
        })
    };

    function getAvailableMethods(methods) {
        var availableMethods = methods.slice(0);
        // remove methods that already have rules
        methodSelectors.forEach(function (x) {
            availableMethods.forEach(function (m) {
                if (m.enabled === undefined || m.enabled) {
                    m.enabled = (m.value != x.val());
                }
            });
        });

        return availableMethods;
    }

    function createNewRule(method, price, methods, valueElement) {
        var availableMethods = getAvailableMethods(methods);
        var wrapper = $('<div>');
        // method selection element
        var selector = $('<select>').appendTo(wrapper).change(
            function () {
                updateValueString(valueElement);
                // disabled any selected methods in other method selectors
                updateSelectors();
            }
        );
        selector.append($('<option>').val('').text('None'));
        for (var i=0; i<availableMethods.length; i++) {
            var option = $('<option>')
                .val(availableMethods[i].value)
                .text(availableMethods[i].label)
                .appendTo(selector);
            if (!availableMethods[i].enabled && availableMethods[i].enabled !== undefined) {
                option.attr('disabled', 'disabled');
            }
        }
        // if a saved rule
        if (method) {
            selector.val(method);
        }
        methodSelectors.push(selector);
        var priceInput = $('<input type="text">').appendTo(wrapper).change(
            function () {
                // validate price
                if (this.value.match(/^\d*\.?\d{1,2}$|^\d+\.?\d{0,2}$/) === null) {
                    this.value = '';
                }
                updateValueString(valueElement);
            }
        ).attr('placeholder', 'Price (ex. 5.00)');
        if (price) {
            priceInput.val(price);
        }
        priceInputs.push(priceInput);
        // deletion
        var deleteButton = $('<button type="button">').text('Remove').click(
            function () {
                wrapper.remove();
                methodSelectors.splice(methodSelectors.indexOf(selector), 1);
                priceInputs.splice(priceInputs.indexOf(priceInput), 1);
                updateValueString(valueElement);
                updateSelectors();
            }
        ).appendTo(wrapper);

        return wrapper;
    }

    function updateSelectors() {
        for (var i=0; i<methodSelectors.length; i++) {
            methodSelectors[i].children('option').each(function () {
                var x = this;
                x.removeAttribute('disabled');
                if (x.value !== '') {
                    for (var p=0; p<methodSelectors.length; p++) {
                        if (methodSelectors[p].val() == x.value && p !== i) {
                            x.setAttribute('disabled', 'disabled');
                        }
                    }
                }
            });
        }
    }
    
    function updateValueString(valueElement) {
        var value = '';
        for (var i=0; i<methodSelectors.length; i++) {
            value += methodSelectors[i].val() + '|' + priceInputs[i].val() + ',';
        }
        valueElement.val(value.slice(0,-1));
    }

    function buildExistingRules(rules, element, methods, valueElement) {
        if (rules) {
            rules = rules.split(',');

            // create rule elements for each existing rule
            for (var i=0; i<rules.length; i++) {
                var method = rules[i].slice(0, rules[i].indexOf('|'));
                var price = rules[i].slice(rules[i].indexOf('|') + 1);

                $(element).append(createNewRule(method, price, methods, valueElement));
            }
        }
    }
});
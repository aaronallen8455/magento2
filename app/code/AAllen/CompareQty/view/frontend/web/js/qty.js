/**
 * Created by Aaron Allen on 7/12/2016.
 */
define(
    ['jquery'],
    function ($) {
        'use strict';
        
        return function (config, element) {
            var url = element.getAttribute('action');

            $(config.inputSelector).change(
                function () {
                    if (!isNaN(this.value) && this.value > 0) {
                        var newUrl;
                        // insert quantity parameter in url
                        newUrl = url.replace(/(?=uenc)/, 'qty/' + this.value + '/');
                        // change quantity in url parameter
                        element.setAttribute('action', newUrl);
                    }else{
                        // invalid entry - revert to default
                        this.value = 1;
                        element.setAttribute('action', url);
                    }
                }
            )
        }
    }
);
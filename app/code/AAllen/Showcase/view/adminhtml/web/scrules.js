/**
 * Created by Aaron Allen on 8/14/2016.
 */
define([
    'Magento_Rule/rules',
    'prototype'
], function (Rules) {
    // extend the VarienRulesForm object to change the request url if its incorrect.
    return Class.create(Rules, {
        showChooserElement: function ($super, chooser) {

            // correct the url if necessary
            var url = chooser.getAttribute('url');
            var index = url.indexOf('chooser/attribute');
            if (index !== -1) {
                var id = this.parent.getAttribute('id');
                // reformat
                url = url.replace(/chooser\/(.*?)(key.*)$/, 'chooser/form/' + id + '/$2$1');
                chooser.setAttribute('url', url);
            }

            $super(chooser);
        }
    });
});
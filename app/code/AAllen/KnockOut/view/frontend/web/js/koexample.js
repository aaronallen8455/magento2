/**
 * Created by Aaron Allen on 6/26/2016.
 */

define(['uiComponent'],
    function (Component) {
        return Component.extend({
            initialize: function () {
                this._super();
                this.sayHello = 'Hello this is content populated with KO!';
            }
        });
    }
);
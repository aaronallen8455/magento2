/**
 * Created by Aaron Allen on 6/26/2016.
 */

define(['uiComponent'],
    function (Component) {
        return Component.extend({
            initialize: function () {
                this._super();
                this.sayHello = 'Hello this is content populated with KO!';
                this.time = new Date().toTimeString();
                this.color = 'red';
                //time is defined as observable
                this.observe(['time', 'color']);
                //update every second
                window.setInterval(this.flush.bind(this), 1000);
            },
            flush: function () {
                var time = new Date();
                this.time(time.toTimeString());
                this.color(this.randomHex());
            },
            randomHex: function () {
                var chars = '0123456789ABCDEF';
                var result = '#';
                for (var i=0; i<6; i++) {
                    result += chars[Math.floor(Math.random()*12)];
                }
                return result;
            }
        });
    }
);
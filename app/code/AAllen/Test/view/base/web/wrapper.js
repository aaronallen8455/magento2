var wrapper = require('mage/utils/wrapper');

function multiply(a, b) {
    return a * b;
}

var wrapped1 = wrapper.wrap(multiply, function (_super) {
    var result = _super();
    return result + 1;
});

var wrapped2 = wrapper.wrap(multiply, function (_super, a, b) {
    a += 1;
    return _super(a, b);
});

multiply(2, 2); // result is 4
wrapped1(2, 2); // result is 5
wrapped2(2, 2); // result is 6

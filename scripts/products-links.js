"use strict";
var page = require('webpage').create();
var args = require('system').args;
var address = args[1];

page.onConsoleMessage = function(msg) {
    console.log(msg);
};

page.open(address, function (status) {
    if (status === "success") {
        page.evaluate(function () {
            products = $('.prod_lst_square_ic .lst_a');
            for (i = 0; i < products.length; i++) {
                result = "http://www.carid.com" + $(products[i]).attr('href');
                console.log(result);
            }
        });
        phantom.exit(0);
    } else {
        phantom.exit(1);
    }
});

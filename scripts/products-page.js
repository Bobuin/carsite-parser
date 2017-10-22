"use strict";
var page = require('webpage').create();
var args = require('system').args;
var address = args[1];

page.onConsoleMessage = function (msg) {
    console.log(msg);
};

page.open(address, function (status) {
    if (status === "success") {
        page.evaluate(function () {
            productName = $('.prod_name').text();
            productId = $('.prod_rating_h b').text();
            productPrice = $('.prod_price:eq(0)').text();
            thumbsCount = $('.prod-thumbs a').length;
            productGallery = '';
            for (i = 0; i < thumbsCount; i++) {
                productGallery = productGallery + "http://www.carid.com" + $('.prod-thumbs a:eq(' + i + ')').attr('href');
                if (i + 1 < thumbsCount) {
                    productGallery = productGallery + ',';
                }
            }
            reviewsCount = $('time').length;
            productReviews = '';
            for (j = 0; j < reviewsCount; j++) {
                productReviews = productReviews + $('time:eq(' + j + ')').attr('content');
                if (j + 1 < reviewsCount) {
                    productReviews = productReviews + ',';
                }
            }
            result =
                    productId + '||' +
                    productName + '||' +
                    productPrice + '||' +
                    productGallery + '||' +
                    productReviews;
            console.log(result);
        });
        phantom.exit(0);
    } else {
        phantom.exit(1);
    }
});

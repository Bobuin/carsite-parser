<?php

use classes\Common;

define('BASE_PATH', __DIR__);

require_once './include/config.php';

$options = getopt("t:u:h");

if (count($options, 1) == 0) {
    echo "Input parsing parameters. Type -h for help.";
    exit;
}

if (isset($options['h'])) {
    echo "-t\tParsing mode:\n"
    . "\t'links' grabbing products pages URLs\n"
    . "\t'products' parsing products data from pages\n"
    . "-u\tURL address for products list page";
    exit;
}

switch ($options['t']) {
    case 'links':
        if (isset($options['u'])) {
            Common::parseProductLinks($options['u']);
        } else {
            echo 'Input parsing URL';
        }
        break;
    case 'products':
        Common::parseProductsInfo();
        break;
    default:
        echo 'Wrong parameter';
        break;
}

<?php
require_once("baseFuncs.php");
if (urlHostEquals('localhost') || urlHostEquals('127.0.0.1') || urlHostEquals('192.168.0.101')) {
    $dbHost = 'localhost';
    $dbName = 'ebt';
    $dbUser = 'ebt';
    $dbPass = '';
} else if (urlHostEquals('ekibizz.tdrs.me')) {
    $dbHost = 'localhost';
    $dbName = 'ekibizz_2017';
    $dbUser = 'ekibizz';
    $dbPass = 'parola';
} else if (urlHostEquals('ekibizz.com')) {
    $dbHost = 'localhost';
    $dbName = 'ekibizz_2018';
    $dbUser = 'ekibizz';
    $dbPass = 'ekibizz';
} else {
    echo "no DB config for " . parse_url(currentPageURL(), PHP_URL_HOST) . "!";
    die("");
}

?>
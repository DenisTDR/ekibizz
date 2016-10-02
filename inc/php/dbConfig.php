<?php
    require_once("baseFuncs.php");
    if(urlHostEquals('localhost') || urlHostEquals('127.0.0.1') || urlHostEquals('192.168.0.101')){
        $dbHost='localhost';
        $dbName='ebt';
        $dbUser='ebt';
        $dbPass='';
    }
    else if(urlHostEquals('ebt.kwix.eu')){
        $dbHost='mysql.kwix.eu';
        $dbName='u427787787_ebt';
        $dbUser='u427787787_ebt';
        $dbPass='romania';
    }
    else if(urlHostEquals('192.168.0.100')){
        $dbHost='192.168.0.101';
        $dbName='ebt';
        $dbUser='ebt';
        $dbPass='';
    }
    else if(urlHostEquals('ekibizz.tdr')){
        $dbHost='localhost';
        $dbName='ebt';
        $dbUser='root';
        $dbPass='';
    }
    else if(urlHostEquals('ekibizz.tdrs.me')){
        $dbHost='localhost';
        $dbName='ekibizz_2016';
        $dbUser='ekibizz';
        $dbPass='parola';
    }
    else{
        echo "no DB config for ".parse_url(currentPageURL(), PHP_URL_HOST)."!";
        die("");
    }

?>
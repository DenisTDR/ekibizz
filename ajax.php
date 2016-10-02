<?php

$status='warning';
require_once('inc/php/baseFuncs.php');

if(isset($_REQUEST['fn']))
{
    $fct=$_REQUEST['fn'];
    if(startsWith($fct, 'u'))
        require_once("pages/u/funcs.php");
    else if(startsWith($fct, 'a'))
        require_once("pages/a/funcs.php");
    else
        require_once("inc/php/funcs.php");
    if(!function_exists($fct)){
        require_once("pages/funcs.php");
        if(!function_exists($fct))
            die("ERRORR: This function doesn't exist!");
    }

    ob_start();
    $ret=array();
    $fct();
    $ret['html']=ob_get_clean();
    if(!isset($ret['status']))
        $ret['status']=$status;
    echo json_encode($ret);
}
else if(isset($_REQUEST['pn'])) {
    //sleep(1);
    require_once("inc/php/funcs.php");
    Page($_REQUEST['pn'], true);
}
else
{echo "WTF should I do with this?"; }
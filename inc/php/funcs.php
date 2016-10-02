<?php

    @session_start();
    require_once("inc/php/baseFuncs.php");
    if(!isset($_SESSION['lang']))
        $_SESSION['lang']='en';
    $TR=array();
    function TR($key, $lang="no"){
        if(isset($TR[$lang][$key]))
            return $TR[$lang][$key];
        if(!isset($_SESSION['lang']))
            $_SESSION['lang']='en';
        $lang=$lang=="no"?$_SESSION['lang']:$lang;
        if(strlen($lang)!=2)return "Invalid language id!";
        require_once("inc/php/mysqli.php"); global $conn;
        $val=$conn->Value("SELECT ".$lang." from translate where `key`=?;", array($key));
        if($val=="")
            return"Translate not found!";
        $val=deSanitize($val);
        return $TR[$lang][$key]=$val;
    }
    function eTR($key, $lang="no"){
        echo TR($key, $lang);
    }
    function PR(){
        $args = func_get_args();
        if(sizeof($args)<2)return"Invalid PR parameters!";
        if(substr_count($args[0], "var") != sizeof($args)-1)return "Invalid params count!";
        for($i=1; $i<sizeof($args); $i++)
            $args[0]=str_replace("var".$i, $args[$i], $args[0]);
        return $args[0];
    }
    function ePR(){
        echo call_user_func_array("PR", func_get_args());
    }
    function setting($key){
        require_once("inc/php/mysqli.php");
        global $conn;
        $val=$conn->Value("SELECT value from setting where key=?", array($key));
        if($val=="")
            return "Setting not found!";
        return $val;
    }

    function Page($page, $ajax=false){
        $p="pages/$page.php";
        if(!file_exists($p))
            if(startsWith($page, 'u')){
                $p="pages/u/$page.php";
                if(!isset($_SESSION['logged']) && $page!='ulogin')
                    $p="pages/403.php";
                if(!file_exists($p))
                    $p="pages/404.php";
            } else
            if(startsWith($page, 'a')){
                $p="pages/a/$page.php";
                if(!isset($_SESSION['admin']))
                    $p="pages/403.php";
                if(!file_exists($p))
                    $p="pages/404.php";
            }else $p="pages/404.php";

        if(!$ajax){
            require_once("inc/php/funcs.php");
            include $p;
        }
        else{
            ob_start();
            global $ret;
            $ret=array();
            $ret['status']="success";
            include $p;
            $ret['html']=ob_get_clean();
            echo json_encode($ret);
        }
    }
    function changeLanguage(){
        sleep(1);
        $toLang=$_POST['toLang'];
        if($_SESSION['lang']!=$toLang){
            require_once("inc/php/mysqli.php"); global $conn, $ret;
            $langs=$conn->Value("Select value from setting where `key`='langs';");
            if(!contains($langs, ' '.$toLang.' ')){
                $ret['status']='error';
                $ret['error']="Language not found!";
                return;
            }
            $_SESSION['lang']=$toLang;
            $ret['js']="window.location=window.location;";
            $ret['status']='success';
        }else{
            global $ret;
            $ret['status']='success';
        }
    }
    function checkPostParametes(){
        $args=func_get_args();
        for($i=0; $i<count($args); $i++)
            if(!isset($_POST[$args[$i]]))
                return false;
        return true;
    }
    function checkParametersLength(){
        $args=func_get_args();
        $x=count($args)/3;
        for($i=0; $i<$x; $i++)
            if(($c=strlen($_POST[$args[$i*3]]))<$args[$i*3+1] || $c>$args[$i*3+2] )
                return false;
        return true;
    }

?>
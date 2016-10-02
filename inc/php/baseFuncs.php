<?php

    function startsWith($haystack, $needle){
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
    function endsWith($haystack, $needle){
        return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
    }
    function contains($haystack, $needle){
        return strpos($haystack,$needle) !== false;
    }
    function currentPageURL(){
        $pageURL = 'http';
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80")
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        return $pageURL;
    }
    function urlHostEquals($host){
        return parse_url(currentPageURL(), PHP_URL_HOST)==$host;
    }

    function resizeImg($origPath, $targetPath, $maxW, $maxH){
        $info=getimagesize($origPath);
        $mime=$info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;
        }
        list($w, $h) = getimagesize($origPath);
        $nw=$w; $nh=$h;

        if($nw>$maxW){
            $nw=$maxW;
            $nh=round($h/$w * $nw);
        }
        if($nh>$maxH){
            $nh=$maxH;
            $nw=round($nw * $w/$h);
        }

        $img = $image_create_func($origPath);
        $tmp = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $nw, $nh, $w, $h);

        if (file_exists($targetPath))
            unlink($targetPath);
        $image_save_func($tmp, "$targetPath.$new_image_ext");
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        return $randomString;
    }
    function reBr($str){
        $str=str_replace("\r\n", "<br>", $str);
        return $str;
    }
    function Br($str){
        $str=str_replace("<br>", "\r\n", $str);
        return $str;
    }
    function sanitizeBR(){
        return str_replace('\\', '&#92;', htmlentities("<br>", ENT_QUOTES));
    }
    function sanitize($data)
    {
        if(is_array($data))
            for($i=0; $i<count($data); $i++)
                $data[$i]=sanitize($data[$i]);
        else
            if(trim($data) != ''){
                $data = reBr($data);
                $data = htmlentities($data, ENT_QUOTES);
               // $data = str_replace('\\', '&#92;', $data);
                if(contains($data, sanitizeBR()))
                    $data=str_replace(sanitizeBR(), "<br>", $data);
            }
        return $data;
    }
    function deSanitize($data){
        if(is_array($data))
            for($i=0; $i<count($data); $i++)
                $data[$i]=deSanitize($data[$i]);
        else
            if(trim($data) != ''){
                $data=str_replace("\\'", "'", $data);
                $data=str_replace('\\"', '"', $data);
                $data = html_entity_decode($data, ENT_QUOTES);
                if(contains($data, sanitizeBR()))
                    $data=str_replace(sanitizeBR(), "<br>", $data);
            }
        return $data;
    }
    /*foreach ($_GET as $key => $value)
        $_GET[$key]=sanitize($value);
    foreach ($_POST as $key => $value)
        $_POST[$key]=sanitize($value);
    foreach ($_REQUEST as $key => $value)
        $_REQUEST[$key]=sanitize($value);
*/
?>
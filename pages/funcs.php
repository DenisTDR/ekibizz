<?php
    function help_request(){
        sleep(1);
        if(!isset($_POST['name']) || !isset($_POST['email'])
          || !isset($_POST['your_pos']) || !isset($_POST['bizz_desc'])
          || !isset($_POST['how_can_we_help']))
        {$ret['error']="Invalid data received!"; $ret['status']="error";return;}
        $name=$_POST['name'];
        $email=$_POST['email'];
        $your_pos=$_POST['your_pos'];
        $bizz_desc=$_POST['bizz_desc'];
        $how_can_we_help=$_POST['how_can_we_help'];

        if(strlen($name)<3 || strlen($email)<5 || strlen($your_pos)<3
            ||strlen($bizz_desc)<5||strlen($how_can_we_help)<5)
        {$ret['status']="warning"; eTR("fields_incomplete"); return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $rez=$conn->NonQuery("INSERT into help_request (name, email, position, description, how_can_help)".
                              "VALUES(?, ?, ?, ?, ?);", array($name, $email, $your_pos, $bizz_desc, $how_can_we_help));
        if($rez!=1) {$ret['status']="warning"; eTR("error_ocurred_retry"); return;}
        global $ret;
        $ret['status']="success";
        eTR("request_registered");
        echo "<br>";
        eTR("we_will_contact_you");
    }
    function location_request(){
        sleep(1);
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('name', 'age', 'profession', 'email', 'phone'))
        {echo "Invalid data received!"; print_r($_POST); $ret['status']="error";return;}
        if(!checkParametersLength('name', 3, 64, 'age', 2, 2, 'profession', 3, 128, 'email', 3, 128, 'phone', 3, 128))
        {eTR('fields_incomplete'); $ret['status']="warning";return;}

        $name =$_POST['name'];
        $age =$_POST['age'];
        $profession =$_POST['profession'];
        $email =$_POST['email'];
        $phone =$_POST['phone'];

        require_once("inc/php/mysqli.php"); global $conn;
        $rez=$conn->NonQuery("INSERT into location_request (name, age, profession, email, phone) VALUES(?, ?, ?, ?, ?);",
                            array($name, $age, $profession, $email, $phone));
        if($rez!=1) {$ret['status']="warning"; eTR("error_ocurred_retry"); return;}
        global $ret;
        $ret['status']="success";
        eTR("request_registered");
        echo "<br>";
        eTR("we_will_contact_you");
    }
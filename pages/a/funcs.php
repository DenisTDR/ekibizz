<?php
    function aupdateTR(){
        usleep(500*1000);
        if(!isset($_POST['key']) || !isset($_POST['col']) || !isset($_POST['val']))
        {$ret['error']="Invalid data received!"; $ret['status']="error";return;}
        require_once("inc/php/mysqli.php");
        global $conn;
        $key=$_POST['key'];
        $col=$_POST['col'];
        $val=$_POST['val'];
        $col=$conn->EscapeString($col);
        //$val=str_replace("\n", "<br>", $val);
        //echo "<br><pre>$val</pre><br>";
        $r=$conn->NonQuery("UPDATE translate set ".$col."=? where `key`=?;", array($val, $key));
        global $ret;
        //if($r==1)
        {
            $ret['status']='success';
            echo "Translate updated! (".$col." for ".$key.")";
            return;
        }
        $ret['status']='error';
        echo  $ret['error']="Something went wrong!<br>";
        //echo "UPDATE translate set ".$col."=$val where `key`=$key;";
    }
    function aCreateAccount(){
        usleep(1*500*1000);
        global $ret;
        require_once("inc/php/funcs.php");
        if(!checkPostParametes('name', 'user', 'pass', 'passagain', 'email', 'id', 'clientOf'))
        {echo "Invalid data received!"; $ret['status']="error";print_r($_POST); return;}
        if(!checkParametersLength('name', 3, 35, 'user', 3, 35, 'pass', 3, 35, 'passagain', 3, 35, 'email', 5, 64, 'id', 1, 15, 'clientOf', 1, 15))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        $name=$_POST['name'];
        $user=$_POST['user'];
        $pass=$_POST['pass'];
        $passagain=$_POST['passagain'];
        $email=$_POST['email'];
        $idNr=$_POST['id'];
        if($pass!=$passagain)
        {eTR('pass_not_match'); $ret['status']="warning";return;}

        require_once("inc/php/mysqli.php"); global $conn;
        if($conn->Count("SELECT count(*) from account where idnumber=?", array($idNr))!=0)
        {echo "This EBO id is already used!"; $ret['status']='error'; return;}
        if($conn->Count("SELECT count(*) from account where user=?", array($user))!=0)
        {echo "This User id is already used!"; $ret['status']='error'; return;}
        if($conn->Count("SELECT count(*) from account where email=?", array($email))!=0)
        {echo "This Email id is already used!"; $ret['status']='error'; return;}
        $r=$conn->NonQuery("INSERT into account (user, password, email, name, idnumber, clientOf) VALUES(?, password(?), ?, ?, ?, ?);",
                        array($user, $pass, $email, $name, $idNr, $_POST['clientOf']));
        if($r!=1){$ret['status']="warning"; eTR("error_ocurred_retry"); return;}
        echo "Account created!";
        $ret['status']='success';
    }
    function aCreateEvent(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('name', 'price', 'location', 'day', 'month', 'year', 'info', 'lati', 'long'))
        {echo "Invalid data received!"; $ret['status']="error";print_r($_POST); return;}
        if(!checkParametersLength('name', 2, 35, 'day', 1, 2, 'month', 1, 2, 'year', 4, 4, 'info', 1, 1024, 'price', 1, 32, 'lati', 1, 32, 'long', 1, 32))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        $date = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
        require_once("inc/php/mysqli.php");  global $conn;
        $p=$_POST;
        if(isset($p['eid'])){
            $c=$conn->NonQuery("UPDATE event set name=?, price=?, location=?, date=?, info=?, latitude=?, longitude=? where id=?;",
                array($p['name'], $p['price'], $p['location'], $date, $p['info'], $p['lati'], $p['long'], $p['eid']));
        }
        else
            $c=$conn->NonQuery("INSERT into event (name, price, location, date, info, latitude, longitude) VALUES(?, ?, ?, ?, ?, ?, ?);",
                    array($p['name'], $p['price'], $p['location'], $date, $p['info'], $p['lati'], $p['long']));
        if(!$c && !isset($p['eid']))
        {echo "An error ocurred!"; $ret['status']='error'; return;}

        if(isset($p['imgFromTmp'])){
            $nn=$_SESSION['loggedIdNr'];
            $ext=$p['imgFromTmp'];
            $small="images/event/".$nn."_small_tmp.".$ext;
            $big="images/event/".$nn."_big_tmp.".$ext;
            if(file_exists($small) && file_exists($big)){
                $eid=isset($p['eid'])?$p['eid']:$conn->LastId();
                @unlink("images/event/".$eid."_small.jpg");
                @unlink("images/event/".$eid."_big.jpg");
                @unlink("images/event/".$eid."_small.png");
                @unlink("images/event/".$eid."_big.png");
                rename($small, "images/event/".$eid."_small.".$ext);
                rename($big, "images/event/".$eid."_big.".$ext);
                $conn->NonQuery("UPDATE event set photo=? where id=?;", array($ext, $eid));
            }
            else echo "not file exists<br>$big<br>$small<br>";
        }
        //else echo "not img from tmp<br>";
        echo"Event created!";
        $ret['status']='success';
    }
    function aEventImgUp(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!isset($_FILES['img']))
            {echo "Invalid data received!"; $ret['status']="error"; return;}
        if(!file_exists($_FILES['img']['tmp_name']))
            {echo "Image file not found!"; $ret['status']="error"; return;}
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        if($ext != 'png' && $ext != 'jpg')
        {ePR(TR('invalid_ext'), 'png/jpg');$ret['status']="warning";return;}

        $nn=generateRandomString(20);
        $nn=$_SESSION['loggedIdNr'];
        resizeImg($_FILES['img']['tmp_name'], "images/event/".$nn."_small_tmp", 150, 150);
        resizeImg($_FILES['img']['tmp_name'], "images/event/".$nn."_big_tmp", 1000, 1000);

        $small="images/event/".$nn."_small_tmp.$ext?".rand(3, 6000);
        $big="images/event/".$nn."_big_tmp.$ext?".rand(3, 6000);
        $ret['script']="$('#tmpImg').attr('src', '$small'); ".
            "$('#tmpAvatar').slideDown(); ".
            "bigImg='$big';";
        $ret['status']='success';
        $ret['ext']=$ext;
        echo "Image uploaded!";
        //print_r($_FILES);
    }
    function aEUUpdate(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('uid', 'eid', 'statut', 'type', 'supervisor', 'ticket'))
        {echo "Invalid data received!"; $ret['status']="error";print_r($_POST); return;}
        if(!checkParametersLength('uid', 1, 15, 'eid', 1, 15, 'statut', 1, 15, 'type', 1, 15, 'supervisor', 1, 10, 'ticket', 1, 32))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        $p=&$_POST; $ret['status']='error';
        if($p['uid']==-1 || $p['eid']==-1)
        {echo "Invalid user/event!"; return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $c=$conn->Count("SELECT count(*) from account where idnumber=?;", array($p['uid']));
        if($c!=1){echo "Invalid user!"; return;}
        $c=$conn->Count("SELECT count(*) from event where id=?;", array($p['eid']));
        if($c!=1){echo "Invalid event!"; return;}
        $c=$conn->Count("SELECT count(*) from account_event where acc_idNr=? and event_id=?;", array($p['uid'], $p['eid']));
        if($c==1){
            $conn->NonQuery("UPDATE account_event set statut=?, supervisor_idNr=?, ticket=?, `type`=? where acc_idNr=? and event_id=?;",
                array($p['statut'], $p['supervisor'], $p['ticket'], $p['type'], $p['uid'], $p['eid']));
        }
        else
            $conn->NonQuery("INSERT into account_event (statut, supervisor_idNr, ticket, `type`, acc_idNr, event_id) VALUES(?, ?, ?, ?, ?, ?) ;",
                array($p['statut'], $p['supervisor'], $p['ticket'], $p['type'], $p['uid'], $p['eid']));

        echo "Done!";
        $ret['status']='success';
    }
    function aEUdelete(){
        global $ret; require_once("inc/php/funcs.php");
        if(!checkPostParametes('uid', 'eid'))
        {echo "Invalid data received!"; $ret['status']="error";print_r($_POST); return;}
        if(!checkParametersLength('uid', 1, 15, 'eid', 1, 15))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        $p=&$_POST;
        if($p['uid']==-1 || $p['eid']==-1)
        {echo "Invalid user/event!"; $ret['status']='error'; return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $conn->NonQuery("DELETE from account_event where acc_idNr=? and event_id=?;", array($p['uid'], $p['eid']));
        echo "Done!";
        $ret['status']='success';
    }
    function adelev(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('td'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!is_array($_POST['td']))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        for($i=0;$i<count($_POST['td']);$i++)
            echo $conn->NonQuery("UPDATE event set deleted=1 where id=?;", array($_POST['td'][$i]));
        $ret['status']='success';
        eTR('done');
    }
    function adelusr(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('td'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $conn->NonQuery("UPDATE account set deleted=1 where idnumber=?;", array($_POST['td']));
        $ret['status']='success';
        eTR('done');
    }
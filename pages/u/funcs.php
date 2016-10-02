<?php
    sleep(1);
    function ulogin(){
        global $ret, $status;
        if(!isset($_POST['user']) || !isset($_POST['pass']))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        $user=$_POST['user'];
        $pass=$_POST['pass'];
        require_once("inc/php/mysqli.php"); require_once("inc/php/funcs.php");
        global $conn;
        $c=$conn->Count("SELECT Count(*) from account where user=? and password=password(?);", array($user, $pass));
        if($c!=1){
            $status='error';
            eTR("invalid_user_pass");
            return;
        }
        $r=$conn->Row("SELECT id, name, idnumber, admin from account where user=? and password=password(?);", array($user, $pass));
        $name=$r[1];
        $id=$r[0];
        $_SESSION['logged']=true;
        $_SESSION['loggedId']=$id;
        $_SESSION['loggedName']=$name;
        $_SESSION['loggedIdNr']=$r[2];
        if($r[3])
            $_SESSION['admin']=1;
        $status="success";
        ePR(TR("login_success"), $name);
        $ret['script']="window.location='?pn=umyaccount';";
    }
    function uChPass(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");

        if(!checkPostParametes('oldpass', 'newpass', 'newpassagain'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('oldpass', 3, 128, 'newpass', 3, 128, 'newpassagain', 3, 128))
        {eTR('fields_incomplete'); $ret['status']="error";return;}

        if(!isset($_SESSION['logged']))
        {echo "You are not logged in!"; $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;

        $c=$conn->Count("SELECT COUNt(*) from account where id=? and password=password(?);", array($_SESSION['loggedId'], $_POST['oldpass']));
        if($c!=1)
        {eTR('invalid_old_password'); $ret['status']="error";return;}
        $newpass=$_POST['newpass'];
        $newpassagain=$_POST['newpassagain'];
        if(strlen($newpass)<5)
        {eTR('pass_not_safe'); $ret['status']="warning";return;}
        if($newpass!=$newpassagain)
        {eTR('pass_not_match'); $ret['status']="warning";return;}
        $c=$conn->NonQuery("UPDATE account set password=password(?) where id=?;", array($newpass, $_SESSION['loggedId']));
        if($c){
            eTR("pass_changed"); $ret['status']='success';
        }
        else{
            eTR("error_ocurred_retry"); $ret['status']='error';
        }
    }
    function uChAvatar(){
        @session_start();
        require_once("inc/php/funcs.php"); global $ret;
        if(!isset($_FILES['img']))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!isset($_SESSION['logged']))
        {echo "You are not logged in!"; $ret['status']="error";return;}
        if($_FILES['img']['error'] || !$_FILES['img']['size'])
        {eTR('error_ocurred_retry'); $ret['status']="error";return;}
        if($_FILES['img']['size']>256*1024)
        {ePR(TR('max_allowed_size'), "256 kb"); $ret['status']="warning";return;}
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        if($ext != 'png' && $ext != 'jpg')
        {ePR(TR('invalid_ext'), 'png/jpg');$ret['status']="warning";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $idnr=$_SESSION['loggedIdNr'];
        $avatar=$conn->Value("SELECT avatar from account where id=?;", array($_SESSION['loggedId']));
        if(file_exists("images/profile/$avatar"))
            unlink("images/profile/$avatar");
        $img="$idnr"."_avatar.".$ext;
        $r=rename($_FILES['img']['tmp_name'], "images/profile/$img");
        if(!$r)
        {eTR('error_ocurred_retry'); $ret['status']="error";return;}
        $conn->NonQuery("Update account set avatar=? where id=?;", array($img, $_SESSION['loggedId']));
        $ret['status']='success';

        $ret['script']="$('#profileImg').attr('src', 'images/profile/".$img."?".rand(3, 1000)."');";
        eTR("image_saved");
    }

    function uUplImg(){
        @session_start(); require_once("inc/php/funcs.php"); global $ret;
        if(!isset($_FILES['img']))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!isset($_SESSION['logged']))
        {echo "You are not logged in!"; $ret['status']="error";return;}
        if($_FILES['img']['error'] || !$_FILES['img']['size'])
        {eTR('error_ocurred_retry'); $ret['status']="error";return;}
        if($_FILES['img']['size']>1024*1024)
        {ePR(TR('max_allowed_size'), "1 Mb"); $ret['status']="warning";return;}
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        if($ext != 'png' && $ext != 'jpg')
        {ePR(TR('invalid_ext'), 'png/jpg');$ret['status']="warning";return;}
		$info=getimagesize($_FILES['img']['tmp_name']);
        $info=$info[3];
        if(strlen($info)<4)
        {eTR('error_ocurred_retry'); $ret['status']="error";return;}
        resizeImg($_FILES['img']['tmp_name'], "images/profile/".$_SESSION['loggedIdNr']."_small_tmp", 150, 150);
        resizeImg($_FILES['img']['tmp_name'], "images/profile/".$_SESSION['loggedIdNr']."_big_tmp", 600, 600);
        $small="images/profile/".$_SESSION['loggedIdNr']."_small_tmp.$ext?".rand(3, 6000);
        $big="images/profile/".$_SESSION['loggedIdNr']."_big_tmp.$ext?".rand(3, 6000);
        $ret['script']="$('#tmpImg').attr('src', '$small'); ".
                "$('#tmpAvatar').slideDown(); ".
                "bigImg='$big';";
        $ret['status']='success';
        eTR("image_upped");
    }
    function uconfirmTmpAvatar(){
        @session_start(); require_once("inc/php/funcs.php"); global $ret;
        if(!isset($_SESSION['logged']))
        {echo "You are not logged in!"; $ret['status']="error";return;}
        $id=$_SESSION['loggedIdNr'];
        $smallT="images/profile/$id"."_small_tmp.";
        $ext=file_exists($smallT."jpg")?'jpg':'png';
        $smallT.=$ext;
        $bigT="images/profile/$id"."_big_tmp.".$ext;
        if(!file_exists($bigT) || !file_exists($smallT))
        {$ret['status']='warning'; echo"No temporary image found!<br>Please upload again!"; return; }

        $small="images/profile/$id"."_small.$ext";
        $big="images/profile/$id"."_big.$ext";

        require_once("inc/php/mysqli.php"); global $conn;
        $oldExt=$conn->Value("SELECT avatar from account where idnumber=?;", array($id));
        if($oldExt!='none'){
            if(file_exists("images/profile/$id"."_small.$oldExt")) unlink("images/profile/$id"."_small.$oldExt");
            if(file_exists("images/profile/$id"."_big.$oldExt")) unlink("images/profile/$id"."_big.$oldExt");
            if(file_exists("images/profile/$id"."_tiny.$oldExt")) unlink("images/profile/$id"."_tiny.$oldExt");
        }
        $conn->NonQuery("UPDATE account set avatar=? where idnumber=?;", array($ext, $id));
        rename($smallT, $small);
        rename($bigT, $big);
        resizeImg("images/profile/$id"."_big.$ext", "images/profile/".$id."_tiny", 50, 50);
        eTR("update_done");
        $ret['status']='success';
        $ret['small']="$small?".rand(3, 6000);
        $ret['big']="$big?".rand(3, 6000);
    }
    function ubizz_idea(){
        global $ret;
        require_once("inc/php/funcs.php");
        if(!checkPostParametes('title', 'desc'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('title', 3, 64, 'desc', 7, 255))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        $title=$_POST['title'];
        $desc=$_POST['desc'];
        require_once("inc/php/funcs.php");
        require_once("inc/php/mysqli.php"); global $conn; @session_start();
        $c=$conn->NonQuery("INSERT into bizz_idea (sender, title, `desc`) VALUES(?, ?, ?);", array($_SESSION['loggedId'], $title, $desc));
        if($c!=1){
            $ret['status']='error';
            eTR("st_went_wrong");
            return;
        }
        global $ret;
        $ret['status']="success";
        eTR("request_registered");
        echo "<br>";
        eTR("we_will_contact_you");
    }
    function uSendMessage(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('uid', 'message'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('uid', 1, 12, 'message', 3, 1024))
        {eTR('fields_incomplete'); $ret['status']="error";return;}

        if(!isset($_SESSION['logged']))
        {echo "You are not logged in!"; $ret['status']="error";return;}
        if(!isset($_POST['subject'])) $_POST['subject']="";
        $_POST['message']=str_replace("\r\n", "<br>", $_POST['message']);
        $uid=$_POST['uid'];
        $mid=$_SESSION['loggedIdNr'];
        require_once("inc/php/mysqli.php"); global $conn; @session_start();
        $r=$conn->Count("Select Count(*) from account where (idnumber=? and clientOf=?) or (idnumber=? and clientOf=?);",
            array($mid, $uid, $uid, $mid));
        //if($r!=1){ echo"You can't send message to this user!"; $ret['status']='error'; return; }

        $r=$conn->NonQuery("INSERT into message (sender, recipient, message, subject, datetime) VALUES(?, ?, ?, ?, now());",
                array($mid, $uid, $_POST['message'], $_POST['subject']));
        if($r!=1)
        { eTR('error_ocurred_retry');$ret['status']='error'; return;}
        eTR('message_sent');
        $ret['status']='success';
    }

    function uupdateBI(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('gender', 'name', 'year', 'day', 'month'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('gender', 1, 1, 'name', 3, 128, 'year', 4, 4, 'day', 1, 2, 'month', 1, 2))
        {eTR('fields_incomplete'); $ret['status']="error";return;}

        require_once("inc/php/mysqli.php"); global $conn;
        $nBD = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
        $c=$conn->NonQuery("Update account set name=?, gender=?, birthdate=? where id=?;", array(
            $_POST['name'], $_POST['gender'], $nBD, $_SESSION['loggedId']
        ));
        $_SESSION['loggedName']=$_POST['name'];
        eTR('update_done');
        $ret['status']='success';
        $age=date('Y', time()-strtotime($nBD))-1970;
        $genders=array('M'=>"male", 'F'=>"female", 'S'=>"unspecified",);
        $ret['script']="$('.nameIdNrA').html('".$_SESSION['loggedName']."<br>[".$_SESSION['loggedIdNr']."]'); ".
                        "$('#genderTD').html('".TR($genders[$_POST['gender']])."'); ".
                        "$('#nameTD').html('".$_SESSION['loggedName']."'); ".
                        "$('#ageTD').html('".$age."'); ";
    }
    function uupdateCI(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('phone', 'email', 'adress', 'country', 'city'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('phone', 6, 15, 'email', 7, 255, 'adress', 3, 255, 'country', 1, 255, 'city', 1, 255))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        $_POST['phone']=intval($_POST['phone']);
        require_once("inc/php/mysqli.php"); global $conn;
        $c=$conn->NonQuery("Update account set email=?, adress=?, phone=?, country=?, city=? where id=?;", array(
            $_POST['email'], $_POST['adress'], $_POST['phone'], $_POST['country'], $_POST['city'], $_SESSION['loggedId']
        ));

        eTR('update_done');
        $ret['status']='success';
        $ret['script']="$('#phoneTD').html('".$_POST['phone']."'); ".
            "$('#emailTD').html('".$_POST['email']."'); ".
            "$('#adressTD').html('".$_POST['adress']."'); ".
            "$('#countryTD').html('".$_POST['country']."'); ".
            "$('#cityTD').html('".$_POST['city']."'); ";
    }
    function uupdateWI(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('occupation', 'skills', 'employement'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('occupation', 3, 255, 'skills', 7, 1024, 'employement', 3, 255))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $c=$conn->NonQuery("Update account set occupation=?, skills=?, employement=? where id=?;", array(
            $_POST['occupation'], $_POST['skills'], $_POST['employement'], $_SESSION['loggedId']
        ));

        eTR('update_done');
        $ret['status']='success';
        $ret['script']="$('#occTD').html('".$_POST['occupation']."'); ".
            "$('#skillDiv').html('".$_POST['skills']."'); ".
            "$('#emplTD').html('".$_POST['employement']."'); ";
    }
    function udelconv(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('td'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!is_array($_POST['td']))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $mid=$_SESSION['loggedIdNr'];
        for($i=0;$i<count($_POST['td']);$i++)
            $conn->NonQuery("UPDATE message set state=4 where (recipient=? and sender=?) or (recipient=? and sender=?)",
            array($mid, $_POST['td'][$i], $_POST['td'][$i], $mid));
        $ret['status']='success';
        eTR('done');
    }
    function udelmsg(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('td'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $mid=$_SESSION['loggedIdNr'];
        $r=$conn->Value("SELECT sender from message where id=?;", array($_POST['td']));
        if($r!=$mid)
        {echo "You can't do this!"; $ret['status']='error'; return;}
        $c=$conn->NonQuery("UPDATE message set state=4 where id=?;", array($_POST['td']));
        $ret['status']=($c==1?'success':'error');
        echo "<br>";
    }
    function ugetmsgs1(){
        global $ret;
        @session_start(); require_once("inc/php/funcs.php");
        if(!checkPostParametes('uid', 'off', 'len'))
        {echo "Invalid data received!"; $ret['status']="error";return;}
        if(!checkParametersLength('uid', 3, 15, 'off', 1, 4, 'len', 1, 2))
        {eTR('fields_incomplete'); $ret['status']="error";return;}
        require_once("inc/php/mysqli.php"); global $conn;
        $p=&$_REQUEST;
        $uid=$p['uid'];
        $mid=$_SESSION['loggedIdNr'];
        $off=$p['off']; $len=$p['len'];
        $c=$conn->Count("Select count(*) from account where idnumber=?;", array($uid));
        if(!$c)
        {echo "User not found!"; $ret['status']='error'; return;}

        $ret['msgs']=$msgs=$conn->Rows("SELECT * from message where ((sender=? and recipient=?) or (sender=? and recipient=?)) and state<=2 order by datetime desc limit ?, ?;",
            array($mid, $uid, $uid, $mid, $off, $len))->allArrays();
        $ret['mname']=$_SESSION['loggedName'];
        $ret['uname']=$conn->Value("SELECT name from account where idnumber=?; ", array($uid));
        $mimg="images/profile/".$mid."_tiny.".$conn->Value("SELECT avatar from account where idnumber=?;", array($mid));
        $ret['mimg']=file_exists($mimg)?$mimg:"images/profile/default.png";
        $uimg="images/profile/".$uid."_tiny.".$conn->Value("SELECT avatar from account where idnumber=?;", array($uid));
        $ret['uimg']=file_exists($uimg)?$uimg:"images/profile/default.png";

        $ret['status']='success';
        echo "...";
    }
?>
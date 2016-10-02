

<?php
$uid=$_REQUEST['uid'];

    if(!isset($_REQUEST['uid']))
    {echo "<div class='error'>User not found!</div>";return;}
    require_once("inc/php/funcs.php");
    require_once("inc/php/mysqli.php"); global $conn; @session_start();
    $mid=$_SESSION['loggedIdNr'];
    $r=$conn->Count("Select Count(*) from account where (idnumber=? and clientOf=?) or (idnumber=? and clientOf=?);", array($mid, $uid, $uid, $mid));
    if($r!=1)
    {echo "<div class='error'>You can't send message to this user!</div>";return;}
    $u=$conn->Row("Select name, avatar from account where idnumber=?;", array($uid));
    $uname=$u[0];
    $uImg="images/profile/".$uid."_small.".$u[1];
    $uImg=file_exists($uImg)?$uImg:"images/profile/default.png";
    $mImg="images/profile/".$mid."_small.".$conn->Value("select avatar from account where idnumber=?;", array($mid));
    $mImg=file_exists($mImg)?$mImg:"images/profile/default.png";
    $mname=$_SESSION['loggedName'];
    $msgs=$conn->Rows("SELECT sender, message, datetime, subject, id from message ".
                   "where ((recipient=? and sender=?) or (sender=? and recipient=?)) and state<=2 order by datetime desc;",
                   array($uid, $mid, $uid, $mid));
     /*
   echo"<h2>$rname</h2>";
   echo"<div class='msgDiv'>";
   while($msg=$msgs->nextRow()){
       //if($msg[0]==$mid)
       echo "<div class='msgMsg ".($msg[0]==$mid?"sent":"received")."'><div class='text '>".$msg[1]."</div>";
       echo "<div class='msgTime'>".$msg[2]."</div></div>";
   }
   echo"</div>";
*/
?>
<style>
    .msgCont{
        width:80%;
        border:0px solid red;
        margin: 0 auto;
        background:white;
        font-family: Verdana,Helvetica,Arial,sans-serif;
        padding: 50px 0 0 0;
    }
    .msgCont>table{
        margin:0 auto;
    }
    .msgCont>table td:first-child{
        width:75px;
        text-align:center;
        cursor:pointer;
    }
    .msgCont>table td{
        vertical-align: top;
        text-align:left;
    }
    .msgCont .sender{
        font-size:0.8em;
    }
    .msgCont .sender img, .pImg{
        max-width:50px;
        max-height:50px;
    }
    .msgCont .subject{
        padding:5px;
        color:#0044CC;
        font-weight: bold;
    }
    .msgCont .message{
        padding:5px;
    }
    .msgCont .infoM{
        font-size:0.8em;
        margin: 0 35px 0 0 ;
    }
    .msgCont .infoM div:first-child{
        font-weight: bold;
        display: inline-block;
    }
    .msgCont .icons{
        float:right;
        margin:5px;
    }
    .msgCont .icons .del{
        width:20px;
        height:20px;
        background: url("images/delete1.png");
        cursor:pointer;
        display: block;
    }
    .msgCont .icons .del:hover{
        background-position: 0 20px;
    }
    .msgCont table td{
        padding-bottom:35px;
    }
    .withConv{
        padding:25px;
        cursor:pointer;
    }
    .withConv div{
        display:inline-block;
        font-size:1.2em;
    }
    .withConv div img{
        vertical-align: middle;
    }
    .sendMsgDiv{
        width:400px;
        margin:0 auto;
        text-align:left
    }
    .sendMsgDiv textarea{
        width:100%;
    }
    .sendMsgDiv div{
        text-align:center;
    }
</style>
<div class="withConv" onclick="gotoPage('uuser&uid=<?php echo $uid; ?>');">
    <div><img class="pImg" src="<?php echo $uImg; ?>" title="Loading image..."/></div>
    <div><?php echo $uname; ?></div>
</div>
<form id="messageForm" class="form">
    <div class="sendMsgDiv">
        <input type="text" name="subject" placeholder="<?php eTR('subject'); ?>"  /><br>
        <textarea name="message" placeholder="<?php eTR('message'); ?>" ></textarea><br>
        <div>
            <input type="submit" id="loginBtn" value="<?php eTR('send'); ?>" />
           <input type="button" id="refreshBtn" class="refresh" />
        </div>
    </div>
</form>
<div class="msgCont">
    <table>
        <?php
            setlocale(LC_TIME, 'ro_RO');
            while($msg=$msgs->nextRow()){
                $sent=$msg[0]==$mid;
                $date=strtotime($msg[2]);
                //$msg[2]=date("D", $date);
                $days2= explode(',', TR('days'));
                $day=$days2[date("N", $date)-1];
                $msg[2]=$day." ".date("d/m h:i", $date);
        ?>
            <tr data="<?php echo $msg[4]; ?>">
                <td><div class="sender" data="<?php echo $sent?$mid:$uid; ?>" onclick="gotoPage('uuser&uid=<?php echo $sent?$mid:$uid; ?>');">
                        <img src="<?php echo $sent?$mImg:$uImg; ?>"/><br>
                        <?php echo $sent?$mname:$uname; ?><br>
                        [<?php echo $sent?$mid:$uid; ?>]
                    </div></td>
                <td>
                    <div>
                        <div class="icons"><?php echo $sent?"<a class='del'></a>":"";  ?></div>
                        <div class="subject"><?php echo $msg[3]; ?></div>
                        <div class="infoM"><div>Dată expediere:</div> <?php echo $msg[2]; ?> </div>
                        <div class="message">
                            <?php echo $msg[1]; ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>

<script>
    $(".msgCont .icons .del").click(function(){
        var th=$(this);
        alertify.set({
            labels : {
                ok     : "<?php eTR('yes'); ?>",
                cancel : "<?php eTR('no'); ?>"
            },
            delay : 5000,
            buttonReverse : false,
            buttonFocus   : "cancel"
        });
        alertify.confirm("<?php eTR('sure_delete_msg'); ?>", function (e) {
            if(!e)return;
            var tr=th.closest('tr')
            var msgId=tr.attr('data');
            ajaxN("fn=udelmsg&td="+msgId, '', please_wait, function(ret){
                if(ret['status']=='success')
                    tr.fadeOut();
            });
        });
    });
    $("#refreshBtn").click(function(){
        var uid=getUrlVars()['uid'];
        gotoPage("umessage&uid="+uid);
    });
    $("#messageForm").on('submit', function(e){
        e.preventDefault();
        var uid=getUrlVars()['uid'];
        var th=$(this);
        var str=th.serialize();
        th.disable();
        ajaxN(str+"&fn=uSendMessage&uid="+uid, "", please_wait, function(ret){
            th.enable();
            if(ret['status']=='success')
                $("#refreshBtn").click();
        });
    });
</script>
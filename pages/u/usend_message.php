<?php
    if(!isset($_REQUEST['rec'])){
        echo "<div class='error'>Recipient not found!</div>";return;
    }
    require_once("inc/php/mysqli.php"); global $conn; @session_start();
    $rid=$_REQUEST['rec'];
    $sid=$_SESSION['loggedIdNr'];
    $r=$conn->Count("Select Count(*) from account where (idnumber=? and clientOf=?) or (idnumber=? and clientOf=?);", array($rid, $sid, $sid, $rid));
    if($r!=1)
    {echo "<div class='error'>You can't send message to this user!</div>";return;}
    $rname=$conn->Value("Select name from account where idnumber=?;", array($rid));

?>
<h1><?php eTR("send_message"); ?></h1>
<div class="mid">
    <form id="messageForm">
        <table class="form" style="margin:0 auto;">
            <tr>
                <td><?php eTR('to'); ?></td>
                <td><input type="text" name="dest" placeholder="<?php eTR('recipient'); ?>" readonly="readonly" disabled="disabled" value="<?php echo $rname; ?>"/></td>
            </tr>
            <input type="hidden" name="dest2" value="<?php echo $rid; ?>" />
            <tr><td></td><td><textarea name="message" placeholder="<?php eTR('message'); ?>" ></textarea></td></tr>
            <tr><td style="text-align: center;" colspan="2"><input type="submit" id="loginBtn" value="<?php eTR('send'); ?>" /></td></tr>
        </table>
    </form>
</div>
<script>
    $("#messageForm").on('submit', function(e){
        e.preventDefault();
        ajaxN($(this).serialize()+"&fn=uSendMessage", "", please_wait, function(ret){
            $(".form :input").enable();
            $("input[name='dest']").disable();
        });
        $("#messageForm :input").disable();
    })
</script>
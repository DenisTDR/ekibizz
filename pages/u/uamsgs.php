<h2></h2>
<?php


?>
<style>

</style>
<div class="bigDiv" >
    <div class="leftPanel">
        <div class="accords">

            <?php
            $mid=$_SESSION['loggedIdNr'];
            require_once("inc/php/mysqli.php"); global $conn;
            ?>
            <div class="accord">
                <div class="title"><?php eTR('admins'); ?></div>
                <div class="cont">
                    <?php
                    $admins=$conn->Rows("SELECT DISTINCT adm.name, adm.idnumber, adm.avatar FROM account AS adm JOIN account AS acc JOIN message AS msg WHERE((msg.recipient = adm.idnumber AND msg.sender = acc.idnumber)OR(msg.sender = adm.idnumber AND msg.recipient = acc.idnumber))AND adm.admin > 0 AND adm.user='admin' and acc.idnumber = ?;",
                        array($mid));
                    while($user=$admins->nextRow()){
                        $img=file_exists("images/profile/$user[1]_tiny.$user[2]")?"$user[1]_tiny.$user[2]":"default.png";
                        echo "<div class='userC' data='$user[1]'><img src='images/profile/$img' alt='Loading...'/><div><b>$user[0]</b><br><div></div></div></div>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
    <div class="rightPanel">
        <h2 style="text-align: left; padding-left:25px;" id="uname">...</h2>
        <div id="rDiv">
        </div>
        <div class="loading" id="loadingmsg" style="display:none"><?php echo TR("loading").".&nbsp;&nbsp;".TR("please_wait"); ?></div>
        <form id="messageForm" class="form" style="display:none;">
            <div class="sendMsgDiv">
                <textarea name="message" placeholder="<?php eTR('message'); ?>" ></textarea>
                <div>
                    <input type="button" id="refreshBtn" class="refresh" /><br>
                    <input type="submit" id="loginBtn" value="<?php eTR('send'); ?>" />
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    var crtId=-1;
    $(".accord").nThC(1).slideDown(750);
    $(".userC>img").on('click', function(){
        gotoPage("uuser&uid="+ $(this).Pa().attr('data'));
    });
    $(".userC>div").on('click', function(){
        var uid=$(this).Pa().attr('data');
        loadMsgs(uid);
    });
    var rdiv=$("#rDiv");
    $(".userC>div").click();
    var loadDiv=$("#loadingmsg");
    function loadMsgs(uid){       $("#messageForm").slideUp();
        rdiv.slideUp(function(){
            rdiv.html("");
            rdiv.slideDown(1);
            loadDiv.slideDown();
            ajaxN("fn=ugetmsgs1&uid="+uid+"&off=0&len=40",
                "", please_wait, function(ret){
                    //console.log(ret['msgs']);
                    $("#uname").html(ret['uname']);
                    rdiv.html("");
                    for(var i=0; i<ret['msgs'].length; i++){
                        var msg1=$("<div></div>"); msg1.toggleClass("msg1");
                        var img=$("<img></img>"); img.attr('src', ret['msgs'][i][1]==uid?ret['uimg']:ret['mimg']);
                        var b=$("<b></b>");b.html(ret['msgs'][i][1]==uid?ret['uname']:ret['mname']);
                        var mdiv=$("<div></div>");mdiv.append(b); mdiv.append("<br>"+ret['msgs'][i][4]+"<div>"+ret['msgs'][i][6]+"</div>");
                        msg1.append(img); msg1.append(mdiv);
                        rdiv.prepend(msg1);
                        //console.log('a');
                    }
                    $("#messageForm").slideDown();
                    loadDiv.slideUp();
                    crtId=uid;
                });
        });
    }
    $("#messageForm").on('submit', function(e){
        e.preventDefault();
        if(crtId==-1)return;
        var th=$(this);
        var str=th.serialize();
        th.disable();
        ajaxN(str+"&fn=uSendMessage&uid="+crtId, "", please_wait, function(ret){
            th.enable();
            if(ret['status']=='success')
                $("#refreshBtn").click();
        });
    });
    $("#refreshBtn").click(function(){
        if(crtId!=-1)
            loadMsgs(crtId);
    });
</script>
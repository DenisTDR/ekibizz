
<div class="bigDiv" >
    <div class="leftPanel">
        <div class="head1"><?php eTR('your_clients'); ?></div>
        <div class="accords">

            <?php
                $mid=$_SESSION['loggedIdNr'];
                require_once("inc/php/mysqli.php"); global $conn;
                $events=$conn->Rows("SELECT DISTINCT ae.event_id, ev.name FROM account AS acc JOIN account_event AS ae JOIN `event` AS ev WHERE ae.supervisor_idNr = ? AND ae.acc_idNr = acc.idnumber AND ev.id = ae.event_id;", array($mid));
                while($event=$events->nextRow()){
                    $eid=$event[0];
                    $users=$conn->Rows("select usr.name, usr.idnumber, usr.avatar from account as usr join account_event as ae where usr.idnumber=ae.acc_idNr and ae.event_id = ? and ae.supervisor_idNr=? and usr.deleted=0;",
                                        array($eid, $mid));
                    echo "<div class='accord'><div class='title'>$event[1]</div><div class='cont'>";
                    while($user=$users->nextRow()){
                        $img=file_exists("images/profile/$user[1]_tiny.$user[2]")?"$user[1]_tiny.$user[2]":"default.png";
                        $lm=$conn->Row("SELECT message, datetime from message where (sender=? and recipient=?) or (sender=? and recipient=?) and state<=2 order by datetime desc limit 0,1;",
                            array($user[1], $mid, $mid, $user[1]));
                        if(isset($lm[1]))
                            if(time()-strtotime($lm[1])>60*60*24)
                                $lm[1]=date("d/m", strtotime($lm[1]));
                            else
                                $lm[1]=date("H:i a", strtotime($lm[1]));
                        else $lm[1]=" ";
                        if(!isset($lm[0])) $lm[0]="&nbsp;";
                        echo "<div class='userC' data='$user[1]'><img src='images/profile/$img' alt='Loading...'/><div><b>$user[0]</b><br>$lm[0]<div>$lm[1]</div></div></div>";
                    }
                    echo "</div></div>";
                }
            ?>
            <div class="accord">
                <div class="title"><?php eTR('allm'); ?></div>
                <div class="cont">
                    <?php
                        $clientOf=$conn->Value("SELECT clientOf from account where idnumber=?;", array($mid));
                        $users=$conn->Rows("SELECT name, idnumber, avatar from account where (clientOf=? or idnumber=?) and deleted=0;", array($mid, $clientOf));
                        while($user=$users->nextRow()){
                            $img=file_exists("images/profile/$user[1]_tiny.$user[2]")?"$user[1]_tiny.$user[2]":"default.png";
                            echo "<div class='userC' data='$user[1]'><img src='images/profile/$img' alt='Loading...'/><div><b>$user[0]</b><br><div></div></div></div>";
                        }
                    ?>
                </div>
            </div>
            <div class="accord" style="display:none;">
                <div class="title">Event3</div>
                <div class="cont">
                    <div class="userC">
                        <img src="images/profile/default.png" /><div><b>sdsdsd</b><br>dfddsd dfdd dfdfdf dfd fsdf dsdf<br>
                        <div>17:30 pm</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rightPanel">
        <h2 style="text-align: left; padding-left:25px;" id="uname">Select a client!</h2>
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
    var crt=-1;
    var lp=$(".accords");
    $(".accord .title").click(function(){
        var th=$(this);
        var thc=th.Pa().index();
        if(thc==crt)
        { th.Pa().nThC(1).slideUp(250); crt=-1; return; }
        if(crt!=-1)
            lp.nThC(crt).nThC(1).slideUp(250);
        th.Pa().nThC(1).slideDown(250);
        crt=th.Pa().index();
        console.log(crt);
    });
    $(".userC>img").on('click', function(){
        gotoPage("uuser&uid="+ $(this).Pa().attr('data'));
    });
    $(".userC>div").on('click', function(){
        var uid=$(this).Pa().attr('data');
        loadMsgs(uid);
    });
    var rdiv=$("#rDiv");
    var loadDiv=$("#loadingmsg");
    function loadMsgs(uid){

        $("#messageForm").slideUp();
        rdiv.slideUp(function(){
            rdiv.html("");
            rdiv.slideDown(1);
            loadDiv.slideDown();
            ajaxN("fn=ugetmsgs1&uid="+uid+"&off=0&len=40",
                "", please_wait, function(ret){
                    //console.log(ret['msgs']);
                    $("#uname").html(ret['uname']);
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
    var crtId=-1;
</script>
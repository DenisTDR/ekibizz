
<h1><?php eTR("messages"); ?></h1>
<?php
    require_once("inc/php/mysqli.php"); global $conn; @session_start();
    $myId=$_SESSION['loggedIdNr'];

?>
<div class="form" style="text-align: left">
    <input type="button" value="<?php eTR('delete'); ?>" id="deleteMsgBtn" />
<table border="0" class="msgTable">
    <thead>
        <tr>
            <td><input type="checkbox" id="allC" /></td>
            <td><?php eTR("user"); ?></td>
            <td><?php eTR("subject"); ?></td>
            <td><?php eTR("last_message"); ?></td>
            <td><?php eTR("time"); ?></td>
        </tr>
    </thead>
    <tbody>
    <?php
        $users=$conn->Column("(select msg1.sender from message as msg1 where msg1.recipient=? and msg1.state<=2 ) union ".
                          "(select msg2.recipient from message as msg2 where msg2.sender=? and msg2.state<=2 ) ", array($myId, $myId));
        $users=array_reverse($users);
        for($i=0; $i<count($users); $i++){
            $lm=$conn->Row("SELECT sender, recipient, subject, message, state, datetime from message where (sender=? and recipient=?) or (sender=? and recipient=?) and state<=2 order by datetime desc limit 0,1;",
                        array($users[$i], $myId, $myId, $users[$i]));
            $us=($users[$i]!=$lm[0])?$lm[1]:$lm[0];
            $une=$conn->Row("SELECT name, avatar from account where idnumber=?;", array($us));
            $userName=$une[0];
            $ext=$une[1];
            $lm[2].=$lm[2]?"":"...";
            $lm[5]=date("Y/m/d H:i",strtotime($lm[5]));
            $img=file_exists("images/profile/".$us."_tiny.$ext")?"images/profile/".$us."_tiny.$ext":"images/profile/default.png";
            echo "<tr><td><input type='checkbox'/></td>".
                "<td><img src='$img' />&nbsp;&nbsp;[$us] $userName</td>".
                "<td>$lm[2]&nbsp;</td>".
                "<td>$lm[3]</td>".
                "<td>$lm[5]</td>".
            "</tr>";
        }

    ?>
    </tbody>
</table>
</div>
<style>
    .msgTable{
        width:100%;
    }
    .msgTable thead td:first-child{
        width: 30px;
    }
    .msgTable td:nth-child(2) img{
        max-width:30px;
        max-height:30px;
        vertical-align: middle;
    }
    .msgTable tbody td:nth-child(2), .msgTable tbody td:nth-child(3), .msgTable tbody td:nth-child(4){
        cursor:pointer;
    }
</style>
<script>
    $(".msgTable").colResizable({liveDrag:true});

    $('.msgTable thead td:first-child').data("sorter", false);
    $('.msgTable').tablesorter({
        widgets        : ['zebra', 'columns'],
        usNumberFormat : false,
        sortReset      : true,
        sortRestart    : true,
        theme		   : 'default',
        sortList: [[4,1]]
    });

    var trs=$(".msgTable tbody tr");
    for(var i=0; i<trs.length; i++){
        var a=trs.nTh(i).children().nTh(1).html();
        var uid=a.split('[')[1].split(']')[0];
        trs.nTh(i).data("uid", uid);
        trs.nTh(i).children().nTh(1).click(function(){
            gotoPage('uuser&uid='+$(this).parent().data('uid'));
        });
        trs.nTh(i).children().nTh(2).click(function(){
            gotoPage('umessage&uid='+$(this).parent().data('uid'));
        });
        trs.nTh(i).children().nTh(3).click(function(){
            gotoPage('umessage&uid='+$(this).parent().data('uid'));
        });
    }
    $("#allC").on('change', function(){
        $(".msgTable tbody input[type='checkbox']").prop('checked', this.checked);
        $("#deleteMsgBtn").able(this.checked && $(".msgTable tbody input[type='checkbox']").length);
    });
    $(".msgTable tbody input[type='checkbox']").on('change', function(){
        if(!this.checked)
        {$("#allC").prop('checked', false);}
        var chks=$(".msgTable tbody input[type='checkbox']");
        var c=0;
        for(var i=0;i<chks.length;i++)
            c+=chks.nTh(i)[0].checked?1:0;
        if(c==chks.length)
            $("#allC").prop('checked', true);
        $("#deleteMsgBtn").able(c>0);
    });
    $("#deleteMsgBtn").disable().click(function(){
        alertify.set({
            labels : {
                ok     : "<?php eTR('yes'); ?>",
                cancel : "<?php eTR('no'); ?>"
            },
            delay : 5000,
            buttonReverse : false,
            buttonFocus   : "cancel"
        });
        alertify.confirm("<?php eTR('sure_delet_conv'); ?>", function (e) {
            if(!e)return;
            var trs=$(".msgTable tbody tr");
            var str="";
            for(var i=0; i<trs.length; i++){
                var tr=trs.nTh(i);
                var chk=tr.children().nTh(0).children().nTh(0);
                if(chk.prop('checked'))
                    str+="&td[]="+tr.data('uid');
            }
            $(".msgTable input").disable();
            ajaxN("fn=udelconv"+str, "", please_wait, function(ret){
               if(ret['status']=='success')
                   for(var i=0; i<trs.length; i++){
                       var tr=trs.nTh(i);
                       var chk=tr.children().nTh(0).children().nTh(0);
                       if(chk.prop('checked'))
                           tr.fadeOut(function(){
                               $(this).remove();
                           });
                   }
                $(".msgTable input").enable();
            });
        });
        return false;
    });
</script>
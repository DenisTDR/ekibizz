<h2><?php eTR("event_member_info_change"); ?></h2>
<?php
    require_once("inc/php/mysqli.php"); global $conn;
    require_once("inc/php/arrays.php");
    $users=$conn->Rows("SELECT name, idnumber from account where deleted=0;")->allArrays();
    $events=$conn->Rows("SELECT id, name, date from event;");
    $uid=isset($_REQUEST['uid'])?$_REQUEST['uid']:-1;
    $eid=isset($_REQUEST['eid'])?$_REQUEST['eid']:-1;
    $userEvent=array(-1, -1, 0, -1);
    if($uid!=-1 && $eid!=-1)
        $userEvent=$conn->Row("SELECT statut, supervisor_idNr, ticket, `type` from account_event where acc_idNr=? and event_id=?;", array($uid, $eid));
?>
<script>
    var uid=<?php echo $uid; ?>;
    var eid=<?php echo $eid; ?>;
</script>

<form id="ueForm">
    <div class="form">
        Event:
        <select name="Events">
            <option value="-1">Select</option>
            <?php
            while($event=$events->nextRow())
                echo "<option value='".$event[0]."'>".date('d/m/Y', strtotime($event[2]))." - ".$event[1]."</option>\n";
            ?>
            <script>
            </script>
        </select>
        <br><br>
        User:
        <select name="userNrEvent">
            <option value="-1">Select</option>
            <?php
                for($i=0; $i<count($users); $i++)
                    echo "<option value='".$users[$i][1]."'>".$users[$i][0]."</option>\n";
            ?>
                <script>
                </script>
        </select>
    </div>
    <div class="thatDiv form">
        <table>
            <tr>
                <td><?php eTR('statut'); ?>:</td>
                <td><select name="statut">
                        <?php
                            foreach ($statuts as $key => $value)
                                echo "<option value='$key'>$value</option>\n";
                        ?>
                </select></td>
            </tr>
            <tr>
                <td><?php eTR('type'); ?>:</td>
                <td><select name="type">
                        <?php
                        foreach ($types as $key => $value)
                            echo "<option value='$key'>$value</option>\n";
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><?php eTR('supervisor'); ?>:</td>
                <td><select name="supervisor">
                        <option value="-1">None</option>
                        <?php
                            for($i=0; $i<count($users); $i++)
                                echo "<option value='".$users[$i][1]."'>".$users[$i][1]." - ".$users[$i][0]."</option>\n";
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><?php eTR('ticket_nr'); ?>:</td>
                <td><input type="text" value="<?php echo $userEvent[2]; ?>" name="ticket"/></td>
            </tr>
            <tr><td></td>
            <td><input type="submit" value="<?php eTR('save'); ?>">
                <input type="button" value="<?php eTR('delete'); ?>" id="delbtn"></td></tr>
        </table>
    </div>
</form>
<?php if($eid!=-1 && $conn->Count("select count(*) from account as acc join account_event as ae where ae.event_id=? and ae.acc_idNr=acc.idnumber;", array($eid))>0){  ?>
    <div style="text-align: left; padding:15px;">
        <div>Registered users to this event ( <?php echo $conn->Value("Select name from event where id=?;", array($eid)); ?> ):</div>
        <table border="0" id="usersTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Statut</th>
                    <th>Type</th>
                    <th>Supervisor</th>
                    <th>Ticket number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $users=$conn->Rows("select concat(acc.name, ' [', acc.idnumber, ']') , ae.statut, ae.type, concat(superv.name, ' [', superv.idnumber, '] '), ae.ticket, acc.idnumber, superv.idnumber from ".
                                        "account as acc join account_event as ae join account as superv ".
                                        "where ae.event_id=? and ae.acc_idNr=acc.idnumber and superv.idnumber=ae.supervisor_idNr;", array($eid));
                    while($user=$users->nextRow()){
                        echo "<tr>".
                        "<td><div onclick='gotoPage(\"uuser&uid=$user[5]\");' class='link'>$user[0]</div></td>".
                        "<td>$user[1]</td><td>$user[2]</td>".
                        "<td><div onclick='gotoPage(\"uuser&uid=$user[6]\");' class='link'>$user[3]</div></td>".
                        "<td>$user[4]</td>".
                        "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<style>
    .thatDiv{
        text-align:center;
        padding:30px 0 0 0;
    }
    .thatDiv>table{
        margin:0 auto;
    }
    .link{
        cursor:pointer;
    }
    .link:hover{
        color:gray;
    }
</style>
<script>
    var x;
    if((x=$("#usersTable")).length){
        x.colResizable({liveDrag:true});
        x.tablesorter({
            widgets        : ['zebra', 'columns'],
            usNumberFormat : false,
            sortReset      : true,
            sortRestart    : true,
            theme		   : 'default'
        });
    }

    $("select[name='userNrEvent']").val(uid).change(function(){
        gotoPage("aeventmember&uid="+($(this).val())+"&eid="+eid);
    });
    $("select[name='Events']").val(eid).change(function(){
        gotoPage("aeventmember&eid="+($(this).val())+"&uid="+uid);
    });
    $("select[name='statut']").val('<?php echo $userEvent[0]; ?>');
    $("select[name='supervisor']").val(<?php echo $userEvent[1]; ?>);
    $("select[name='type']").val('<?php echo $userEvent[3]; ?>');

    $("#ueForm").on('submit', function(e){
        e.preventDefault();
        var th=$(this);
        var str=th.serialize();
        th.disable();
        str+="&fn=aEUUpdate&uid="+uid+"&eid="+eid;
        ajaxN(str, "", please_wait, function(ret){
            th.enable();
            if(ret['status']=='success')
                loadPage(window.location.href.split('?')[1].substring(3));
        });
    });
    $("#delbtn").click(function(){
        var form=$(".thatDiv.form");
        form.disable();
        ajaxN("fn=aEUdelete&uid="+uid+"&eid="+eid, "", please_wait, function(ret){
            form.enable();
            form.clearVals();
            if(ret['status']=='success')
                loadPage(window.location.href.split('?')[1].substring(3));
        });
    });
</script>
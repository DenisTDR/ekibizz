<h2>List of users</h2>
<?php
    require_once("inc/php/mysqli.php"); global $conn;
    $users=$conn->Rows("SELECT name, idnumber, avatar from account where deleted=0;");
?>

    <table class="clientsTable">
        <thead>
        <tr>
            <td><b><?php eTR("name"); ?></b></td>
            <td><b><?php eTR("ebo_id"); ?></b></td>
            <td><b>Eveniment curent</b></td>
            <td><b>Profil/ Mesaj/ Delete</b></td>
        </tr>
        </thead>
        <tbody>
        <?php
        while($user=$users->nextRow()){
            $img="images/profile/$user[1]_small.$user[2]";
            $img=file_exists($img)?$img:"images/profile/default.png";
            echo "<tr><td>$user[0]</td><td>[$user[1]]</td>";
            $nextEv=$conn->Row("SELECT e.id, e.`name`, e.date, ae.statut, ae.type, ae.supervisor_idNr, ae.ticket from `event` as e join account_event as ae where ae.event_id=e.id and ae.acc_idNr=? and e.date>CURDATE() order by e.date asc limit 0, 1;", array($user[1]));
            echo !$nextEv[0]?"<td>none</td>":"<td><b><a onclick='gotoPage(\"uevent&eid=$nextEv[0]\");'>$nextEv[1]</a></b><br>$nextEv[3]<br>$nextEv[4]<br>Supervisor: <a onclick='gotoPage(\"uuser&uid=$nextEv[5]\");'>[$nextEv[5]]</a><br>Ticket: $nextEv[6]</td>";

            echo "<td><a onclick='gotoPage(\"uuser&uid=$user[1]\");'><img src='$img' /></a>";
            echo "<a onclick='msgUsr($user[1]);'><img src='images/mailA.png'></a>";
            echo "<a onclick='delUsr($user[1], \"$user[0]\");'><img src='images/binr.png'></a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

<style>
    .clientsTable{
        width:90%;
        font-size:1.2em;
        margin:0 auto;
        border:1px solid #0077b3;
        text-align: left;
    }
    .clientsTable td a img{
        width:40px;
        margin-left:5px;
    }
    .clientsTable td a{
        opacity: 0.7;
    }
    .clientsTable td a:hover{
        opacity: 1;
    }
    .clientsTable tbody td:nth-child(3){
        font-size:0.7em;
        line-height: 105%;
    }

</style>
<script>
    $(".clientsTable").colResizable({liveDrag:true});
    $('.clientsTable').tablesorter({
        widgets        : ['zebra', 'columns'],
        usNumberFormat : false,
        sortReset      : true,
        sortRestart    : true,
        theme		   : 'default'
    });
    function delUsr(id, name){
        //alert(id);
        alertify.confirm( "Esti sigur ca vrei sa stergi userul <b>"+name+" ["+id+"]</b> ?", function (e) {
            if (e) {
                ajaxN('fn=adelusr&td='+id, "Se sterge user", "", function(ret){  });
            }
        });
    }
    function msgUsr(id){
        gotoPage('uclients');
        repeatA(id);
    }
    function repeatA(id){
        setTimeout(function(){
            if(loading_flag)
                repeatA(id);
            else
                loadMsgs(id);
        }, 500);

    }
</script>
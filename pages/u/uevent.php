<h2></h2>
<?php
require_once("inc/php/funcs.php");
require_once("inc/php/arrays.php");
require_once("inc/php/mysqli.php"); global $conn;
@session_start();
if(isset($_REQUEST['eid']))
    $eventId=$_REQUEST['eid'];
else{
    ?>
    <script>
        $(document).ready(function(){
            gotoUPage("uevents");
        });
    </script>
<?php
    return;
}
$event=$conn->Row("SELECT * from event where id=?;", array($eventId));
//print_r($event);
$accev=$conn->Count("SELECT count(*) from account_event where acc_idNr=? and event_id=?;", array($_SESSION['loggedIdNr'], $eventId));
$ext=$event[6];;

?>
<div class="headerE">
    <img src="images/event/<?php echo $eventId."_big.".$ext; ?>" alt="Loading image..."/>
    <div class="title"><?php echo $event[1]; ?></div>
</div>
<div class="infoD">
    <table class="infoT">
        <tr>
            <td class="infoL">
                <div class='infoH'><?php eTR("personal_info"); ?></div>
                <?php
                if(!$accev)
                {eTR("not_registered_event_member"); echo "<br><br><br>";}
                else{
                    $accev=$conn->Row("SELECT * from account_event where acc_idNr=? and event_id=?;", array($_SESSION['loggedIdNr'], $eventId));
                    ?>
                <table>
                    <tr>
                        <td><?php eTR('statut'); ?>:</td>
                        <td><?php echo $statuts[$accev[3]]; ?></td>
                    </tr>
                    <tr>
                        <td><?php eTR('type'); ?>:</td>
                        <td><?php echo $types[$accev[6]]; ?></td>
                    </tr>
                    <tr>
                        <td><?php eTR('supervisor'); ?>:</td>
                        <td>[<?php echo $accev[4]; ?>]</td>
                    </tr>
                    <tr>
                        <td><?php eTR('ticket_nr'); ?>:</td>
                        <td>[<?php echo $accev[5]; ?>]</td>
                    </tr>
                </table>
                <?php } ?>
            </td>
            <td class="infoR">
                <div class='infoH'><?php eTR("event_info"); ?></div>
                <table>
                    <tr>
                        <td><?php eTR("location"); ?>:</td>
                        <td><?php echo $event[2]; ?></td>
                    </tr>
                    <tr>
                        <td><?php eTR("date"); ?>:</td>
                        <td><?php echo date("d/ m/ Y", strtotime($event[4])); ?></td>
                    </tr>
                    <tr>
                        <td><?php eTR("price"); ?>:</td>
                        <td><?php echo $event[3]; ?></td>
                    </tr>
                </table>
            </td>
            <?php if(strlen($event[8])>3 && strlen($event[9])>3){ ?>
            <td>
                <div id="mapCanvas" style="border:0px solid red; width: 200px;height: 100px" >Loading map...</div>
               <script>


                    var flag=false;
                    function initialize() {
                        var mapOptions = {
                            center: new google.maps.LatLng(<?php echo $event[8]; ?>, <?php echo $event[9]; ?>),
                            zoom: 8
                        };
                        var map = new google.maps.Map(document.getElementById("mapCanvas"),
                            mapOptions);
                        flag=true;
                    }
                    google.maps.event.addDomListener(window, 'load', initialize);
                    setTimeout(function(){
                        if(!flag)
                            initialize();
                    }, 1000);
                </script>
                <a href="https://www.google.com/maps/?q=<?php echo $event[8]; ?>,<?php echo $event[9]; ?>&ll=<?php echo $event[8]; ?>,<?php echo $event[9]; ?>" target="_blank"><?php eTR('open_google_maps'); ?></a>
            </td>
            <?php } ?>
        </tr>
    </table>
</div>

<div class="moreInfoDiv">
    <p class="h3"><?php eTR("more_info_event"); ?></p>
    <?php echo $event[5]; ?>
</div>
<div class="yourClientsDiv">
    <?php
        $myUsers=$conn->Rows("SELECT acc. NAME, acc.idnumber FROM account AS acc JOIN account_event AS ev ".
                            "WHERE ev.supervisor_idNr = ? AND ev.acc_idNr = acc.idnumber AND ev.event_id = ?;", array($_SESSION['loggedIdNr'], $eventId));
        if($myUsers->row_count>0){
            ?>
                <p class="h3"><?php eTR("brought_clients_event"); ?></p>
                <table class="clientsTable" border="1">
                    <tr>
                        <td><b><?php eTR("name"); ?></b></td>
                        <td><b><?php eTR("ebo_id"); ?></b></td>
                    </tr>
                    <?php
                        while($myUser=$myUsers->nextRow())
                            echo "<tr><td>$myUser[0]</td><td>[$myUser[1]]</td></tr>";

                    ?>
                </table>
            <?php
        }

    ?>
</div>
<style>
    .headerE{
        text-align:center;
    }
    .headerE img{
        max-width:100%;
    }
    .headerE .title{
        font-size:2em;
        text-align:left;
        padding:15px 0 25px 30px;
    }
    .infoD{
        text-align:center;
    }
    .infoT{
        width:95%;
        margin:0 auto;
    }
    .infoR, .infoL{
        vertical-align: top;
        width:50%;
        padding:5px;
    }
    .infoH{
        font-size:1.3em;
        font-weight: bold;
        padding:0 0 0 15px;
    }
    .moreInfoDiv{
        text-align:left;
        padding:30px;
    }
    .moreInfoDiv p.h3{
        padding:25px 0 0 20px;
    }
    .yourClientsDiv{
        text-align:left;
        padding:30px;
    }
    .yourClietsDiv p.h3{
        padding:25px 0 0 20px;
    }
    .clientsTable{
        width:350px;
        text-align: center;
        font-size:1.2em;
    }
    .clientsTable td a img{
        width:35px;
    }
    .clientsTable td a{
        opacity: 0.7;
    }
    .clientsTable td a:hover{
        opacity: 1;
    }
</style>
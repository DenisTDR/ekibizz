<?php
    require_once("inc/php/funcs.php");
    require_once("inc/php/mysqli.php"); global $conn;
    @session_start();
    $y=date("Y", time());
    $m=date("m", time());
    $d=date("d", time());
    $crtDate="$y-$m-$d";
    $crt=$conn->Column("SELECT id from event where deleted=0 and date>=? order by date asc limit 0,2;", array($crtDate));
    //print_r($crt);
?>
<div class="form">

    <?php if(isset($crt[0])){ ?>
    <input type="button" value="<?php eTR("crt_event"); ?>" onclick="gotoPage('uevent&eid=<?php echo $crt[0]; ?>');">
    <?php } if(isset($crt[1])){ ?>
    <input type="button" value="<?php eTR("next_event"); ?>" onclick="gotoPage('uevent&eid=<?php echo $crt[1]; ?>');">
    <?php } ?>
</div>
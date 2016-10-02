<?php
    require_once("inc/php/mysqli.php");global $conn;
?>
<h1><?php eTR("my_account"); ?></h1>

<div id="contentUDiv">
    <?php
    if(isset($_REQUEST['upn']))
        Page($_REQUEST['upn']);
    else
        include "pages/u/uhome.php";
    ?>
</div>
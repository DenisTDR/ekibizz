<?php
    $id=$_SESSION['loggedIdNr'];
    $small="images/profile/$id"."_small";
    require_once("inc/php/mysqli.php"); global $conn;
    $ext=$conn->Value("SELECT avatar from account where idnumber=?;", array($id));
    $small.=".".$ext;
    $img=file_exists($small)?$small:"images/profile/default.png";
    $big="images/profile/$id"."_big.$ext";
?>
<div class="userMenu">
    <ul>
        <li style="text-align: center;"><a class="top"><img class='avatar' src="<?php echo $img; ?>" id="profileImg"  /></a></li>
        <li style="text-align: center;"><a class="nameIdNrA top"><?php echo $_SESSION['loggedName']; ?></a>
        </li>
        <li><a onclick="gotoPage('umyaccount');"><img src="images/home-icon.png" /> <?php eTR('home'); ?></a></li>
        <li><a onclick="gotoPage('uclients');"><img src="images/clients1-icon.png" /><?php eTR('your_clients'); ?></a></li>
        <li><a onclick="gotoPage('uamsgs');"><img src="images/clients1-icon.png" /><?php eTR('admin_messages'); ?></a></li>
        <li><a onclick="gotoUPage('usettings');"><img src="images/settings-icon.png" /><?php eTR('settings'); ?></a></li>
        <?php if(isset($_SESSION['admin'])){ ?>
            <li><a onclick="gotoUPage('asettings');"><img src="images/settingsA-icon.png" />Admin <?php eTR("settings"); ?></a></li>
        <?php } ?>
        <!--li><a onclick="gotoUPage('umessages');"><img src="images/mail-icon.png" /><?php eTR("messages"); ?></a></li-->
        <li><a onclick="gotoUPage('uevents');"><?php eTR("events"); ?></a></li>
        <li><a onclick="gotoUPage('ushareurbizzidea');"><?php eTR("share_your_bizz_idea"); ?></a></li>


        <li><a onclick="gotoUPage('ulogout');"><img src="images/logout-icon.png" /><?php eTR("logout"); ?></a></li>

    </ul>
</div>
<script>
    $(function(){
        <?php if(file_exists($big)){ ?>
            $('#profileImg').click(function(){
                previewImage('<?php echo $big; ?>');
            });
        <?php } ?>
        var x=$(".userMenu");
        $("#contentDiv").css( 'margin-left',x.css('width'));
        x.css('top', $(".navbar.navbar-default").css('height'));
    });
</script>
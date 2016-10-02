<?php
    require_once("inc/php/funcs.php");
    require_once("inc/php/arrays.php");
    @session_start();
    if(!isset($_REQUEST['uid']))
    {echo "<div class='warning'>User id not found!</div>"; return;}
    require_once("inc/php/mysqli.php"); global $conn;
    $p=&$_REQUEST;
    $c=$conn->Count("SELECT count(*) from account where idnumber=?;", array($p['uid']));
    if($c!=1)
    {echo "<div class='warning'>Invalid user id!</div>"; return;}
    $user=$conn->Row("SELECT * from account where idnumber=?;", array($p['uid']));

    $img="images/profile/$user[9]_small.$user[10]";
    $img=file_exists($img)?$img:"images/profile/default.png";
    $imgb="images/profile/$user[9]_big.$user[10]";
    $imgb=file_exists($imgb)?$imgb:false;

    $uBD=explode('-', $user[4]);
    $uBD[0]=intval($uBD[0]);$uBD[1]=intval($uBD[1]);$uBD[2]=intval($uBD[2]);
    if($uBD[0]==0 && $uBD[1]==0 && $uBD[2]==0 )
        $age="-";
    else
        $age=date('Y', time()-strtotime($user[4]))-1970;
?>
<div class="headerU" >
    <div class="name"><?php echo $user[5]; ?></div>
    <img src="<?php echo $img; ?>" <?php if($imgb) echo"onclick='previewImage(\"$imgb\");'"; ?> />
</div>
<?php
    if(isset($_SESSION['admin'])){
?>
<div class="infoD">
    <div class="mid">
        <table class="mid form ttable" border="0">
            <tr>
                <td><div class="subPatrat" style="border-color:#77BC78">
                        <div class="h"><?php eTR('basic_info'); ?></div>
                        <table>
                            <tr>
                                <td><?php eTR("gender"); ?></td>
                                <td id="genderTD"><?php eTR($genders[$user[14]]); ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("name"); ?></td>
                                <td id="nameTD"><?php echo $user[5]; ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("age"); ?></td>
                                <td id="ageTD"><?php echo $age; ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("birthdate"); ?></td>
                                <td id="ageTD"><?php echo "$uBD[2]/$uBD[1]/$uBD[0]"; ?></td>
                            </tr>
                        </table>
                    </div></td>
                <td><div class="subPatrat" style="border-color:#0CB2C7">
                        <div class="h"><?php eTR('work'); ?></div>
                        <table>
                            <tr>
                                <td><?php eTR("occupation"); ?></td>
                                <td id="occTD"><?php echo $user[11]; ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("skills"); ?></td>
                                <td ><div id="skillDiv" style="width:150px; cursor:pointer;" class="wrapped"><?php echo $user[12]; ?></div></td>
                            </tr>
                            <tr>
                                <td><?php eTR("employement"); ?></td>
                                <td ><div id="emplTD" style="width:150px; cursor:pointer;" class="wrapped"><?php echo $user[13]; ?></div></td>
                            </tr>
                            <script>
                                $("#skillDiv").click(function(){
                                    $("#skillDiv").toggleClass('wrapped');
                                });
                                $("#emplTD").click(function(){
                                    $("#emplTD").toggleClass('wrapped');
                                });
                            </script>
                        </table>
                    </div></td>
            </tr>
            <tr>
                <td><div class="subPatrat" style="border-color: #F5B66B">
                        <div class="h"><?php eTR('contact_info'); ?></div>
                        <table>
                            <tr>
                                <td><?php eTR("phone"); ?></td>
                                <td id="phoneTD"><?php echo $user[15]; ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("email_adress"); ?></td>
                                <td id="emailTD"><?php echo $user[3]; ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("adress"); ?></td>
                                <td> <div id="adressTD" style="width:150px; cursor:pointer;" class="wrapped"><?php echo $user[16]; ?></div></td>
                            </tr>
                            <tr>
                                <td><?php eTR("country"); ?></td>
                                <td id="countryTD"><?php echo $user[17]; ?></td>
                            </tr>
                            <tr>
                                <td><?php eTR("city"); ?></td>
                                <td id="cityTD"><?php echo $user[18]; ?></td>
                            </tr>
                            <script>
                                $("#adressTD").click(function(){
                                    $("#adressTD").toggleClass('wrapped');
                                });
                            </script>
                        </table>
                    </div></td>
                <td><div class="subPatrat" style="border-color: #F9E561">
                        <div class="h"><?php eTR('account_sett'); ?></div>
                        <table>
                            <tr>
                                <td><?php eTR("ebo_id"); ?></td>
                                <td>[<?php echo $user[9]; ?>]</td>
                            </tr>
                            <tr>
                                <td><?php eTR("clientof"); ?></td>
                                <td ><a class="cot">[<?php echo $user[8]; ?>]</a> </td>
                            </tr>
                        </table>
                    </div></td>
            </tr>
        </table>
    </div>

</div>
<?php } else { ?>
    <div style="text-align:center;">
        <div class="subPatrat" style="border-color:#77BC78; margin:0 auto;">
            <div class="h"><?php eTR('basic_info'); ?></div>
            <table>
                <tr>
                    <td><?php eTR("gender"); ?></td>
                    <td id="genderTD"><?php eTR($genders[$user[14]]); ?></td>
                </tr>
                <tr>
                    <td><?php eTR("name"); ?></td>
                    <td id="nameTD"><?php echo $user[5]; ?></td>
                </tr>
                <tr>
                    <td><?php eTR("age"); ?></td>
                    <td id="ageTD"><?php echo $age; ?></td>
                </tr>
                <?php
                    if($user[6])
                        echo "<tr><td colspan='2'><h2>".TR('this_is_admin').".</h2></td></tr>"

                ?>
            </table>
        </div>
    </div>
<?php } ?>
<style>
    .name{
        font-size:2em;
        font-weight:bold;
        text-align:center;
    }
    .headerU{
    }
    .headerU img{
        max-width:100px;
        max-height: 100px;
        margin: 10px;
        border:4px solid gray;
        border-radius:5px;
        cursor:pointer;
        opacity:0.8;
    }
    .headerU img:hover{
        opacity:  1;
        border:4px solid black;

    }
    .subPatrat{
        border-top:4px solid green;
        width:300px;
        font-size:0.9em;
        margin:10px;
        text-align:left;
    }
    .subPatrat .h{
        font-size:1.1em;
        padding:6px 0 15px 15px;
    }
    .subPatrat a{
        color:#66A8D1;
    }
    .subPatrat table tr td:last-child{
        color:gray;
        font-size:0.95em;
        vertical-align: bottom;
    }
    .subPatrat table tr td:first-child{
        min-width:100px;
    }
    .subPatrat table{
        padding-left:15px;
    }
    .ttable{
        width:60%;
        background: white;
        padding:10px;
    }
    .ttable td{
        vertical-align: top;
    }
    .wrapped{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height:2.5em
    }
    .cot{
        cursor:default;
    }
</style>
<script>
    var cot=$('.cot');
    if(cot.html()!='[-1]'){
        cot.click(function(){gotoPage('uuser&uid='+cot.html().substring(1, cot.html().length-1))});;
        cot.toggleClass('cot');
    }
</script>
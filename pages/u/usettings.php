<?php
    require_once("inc/php/funcs.php");
    require_once("inc/php/arrays.php");
    require_once("inc/php/mysqli.php"); global $conn;
    $user=$conn->Row("SELECT user, email, name, clientOf, idnumber, birthdate, occupation, skills, gender, phone, adress, employement, country, city from account where id=?",
        array($_SESSION['loggedId']));
    $uBD=explode('-', $user[5]);
    $uBD[0]=intval($uBD[0]);$uBD[1]=intval($uBD[1]);$uBD[2]=intval($uBD[2]);
    $age=date('Y', time()-strtotime($user[5]))-1970;
?>
<style>
    .subPatrat{
        border-top:4px solid green;
        width:300px;
        font-size:0.9em;
        margin:10px;
    }
    .subPatrat .h{
        font-size:1.2em;
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

</style>
<h1><?php eTR("settings"); ?></h1>
<div class="mid">
    <table class="mid form ttable" border="0">
        <tr>
            <td><div class="subPatrat" style="border-color:#77BC78">
                    <div class="h"><?php eTR('basic_info'); ?></div>
                    <table>
                        <tr>
                            <td><?php eTR("gender"); ?></td>
                            <td id="genderTD"><?php eTR($genders[$user[8]]); ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("name"); ?></td>
                            <td id="nameTD"><?php echo $user[2]; ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("age"); ?></td>
                            <td id="ageTD"><?php echo $age; ?></td>
                        </tr>
                        <tr><td><a onclick="dH(); crtP=$('#basicInfoP').slideDown();">Edit</a></td></tr>
                    </table>
            </div></td>
            <td><div class="subPatrat" style="border-color:#0CB2C7">
                    <div class="h"><?php eTR('work'); ?></div>
                    <table>
                        <tr>
                            <td><?php eTR("occupation"); ?></td>
                            <td id="occTD"><?php echo $user[6]; ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("skills"); ?></td>
                            <td ><div id="skillDiv" style="width:150px; cursor:pointer;" class="wrapped"><?php echo $user[7]; ?></div></td>
                        </tr>
                        <tr>
                            <td><?php eTR("employement"); ?></td>
                            <td ><div id="emplTD" style="width:150px; cursor:pointer;" class="wrapped"><?php echo $user[11]; ?></div></td>
                        </tr>
                        <script>
                            $("#skillDiv").click(function(){
                                $("#skillDiv").toggleClass('wrapped');
                            });
                            $("#emplTD").click(function(){
                                $("#emplTD").toggleClass('wrapped');
                            });
                        </script>
                        <tr><td><a onclick=" dH(); crtP=$('#workP').slideDown();">Edit</a></td></tr>
                    </table>
                </div></td>
        </tr>
        <tr>
            <td><div class="subPatrat" style="border-color: #F5B66B">
                    <div class="h"><?php eTR('contact_info'); ?></div>
                    <table>
                        <tr>
                            <td><?php eTR("phone"); ?></td>
                            <td id="phoneTD"><?php echo $user[9]; ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("email_adress"); ?></td>
                            <td id="emailTD"><?php echo $user[1]; ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("adress"); ?></td>
                            <td> <div id="adressTD" style="width:150px; cursor:pointer;" class="wrapped"><?php echo $user[10]; ?></div></td>
                        </tr>
                        <tr>
                            <td><?php eTR("country"); ?></td>
                            <td id="countryTD"><?php echo $user[12]; ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("city"); ?></td>
                            <td id="cityTD"><?php echo $user[13]; ?></td>
                        </tr>
                        <script>
                            $("#adressTD").click(function(){
                                $("#adressTD").toggleClass('wrapped');
                            });
                        </script>
                        <tr><td><a onclick=" dH();  crtP=$('#contactP').slideDown();">Edit</a></td></tr>
                    </table>
                </div></td>
            <td><div class="subPatrat" style="border-color: #F9E561">
                    <div class="h"><?php eTR('account_sett'); ?></div>
                    <table>
                        <tr>
                            <td><?php eTR("ebo_id"); ?></td>
                            <td><?php echo $user[4]; ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("change_avatar"); ?></td>
                            <td><?php eTR("change"); ?></td>
                        </tr>
                        <tr>
                            <td><?php eTR("password"); ?></td>
                            <td><?php eTR("change"); ?></td>
                        </tr>
                        <tr><td><a onclick=" dH(); crtP=$('#settP').slideDown();">Edit</a></td></tr>
                    </table>
                </div></td>
        </tr>
    </table>
</div>
<style>
    .hover1{
        background:black;
        opacity: 0.2;
        position:fixed;
        width:100%;
        height:100%;
        top:0;
        left:0;
        z-index: 10;
    }
    .PContainer{
        display:table;
        vertical-align: middle;
        text-align:center;
        z-index: 11;
        top: 0;
        left:0;
        width:100%;
        height: 100%;
        position:absolute;
        background:transparent;
    }
    .PContainer>div{
        display:table-cell;
        vertical-align: middle;
        text-align:center;
    }
    .formP{
        z-index: 12;
        width: 450px;
        height: 350px;
        display:inline-block;
        margin:0 auto;
        background: white;
        box-shadow: 5px 5px 20px #888888;
        position:relative;
    }
    .formP .h{

        font-size:1.4em;
        color:white;
        padding:15px;
        font-weight: bold;
    }
    .formP .h .close{
        float:right;
        max-width:25px;
        cursor:pointer;
        opacity: 0.7;
    }
    .formP .h .close:hover{
        opacity: 1;
    }
    .formP table{
        width:100%;
        padding:15px;
        margin-bottom:20px;
    }
    .formP table tr td:first-child{
        vertical-align: top;
    }
    .formP .footer{
        position:absolute;
        bottom:0;
        right:0;
        padding:10px;
    }
    .form input[type="submit"].uploadB{
        background-image: url("images/upload1.png");
        background-size:100% 100%;
        background-color:transparent;
        width:40px;
        height:40px;
        opacity:0.6;
    }
    .form input[type="submit"].uploadB:hover{
        opacity:1;
    }
</style>
<div class="hover1" style="display:none;">
</div>
<div class="PContainer" style="display:none;">
    <div class="hover2">
    <div id="basicInfoP" class="formP" style="display:none;">
        <form>
        <div class="h" style="background: #77BC78;"><?php eTR('basic_info'); ?><img class="close" src="images/close2.png" /></div>
        <table border="0" class="form">
            <tr>
                <td><?php eTR("gender"); ?></td>
                <td><select name="gender">
                        <option value="S"><?php eTR('unspecified'); ?></option>
                        <option value="M"><?php eTR('male'); ?></option>
                        <option value="F"><?php eTR('female'); ?></option>
                    </select></td>
                <script>
                    $("select[name='gender']").val('<?php echo $user[8]; ?>');
                </script>
            </tr>
            <tr>
                <td><?php eTR("name"); ?></td>
                <td><input type='text' value='<?php echo $user[2]; ?>' name="name" /></td>
            </tr>
            <tr>
                <td><?php eTR("birthdate"); ?></td>
                <td>
                    <select name="day" ><?php for($i=1;$i<32;$i++) echo "<option value='$i' >$i</option>\n"; ?></select>
                    <select name="month"> <?php for($i=1;$i<13;$i++) echo "<option value='$i' >$i</option>\n"; ?></select>
                    <select name="year"> <?php for($i=2006;$i>1950;$i--) echo "<option value='$i' >$i</option>\n"; ?></select>
                    <script>
                        $("select[name='day']").val('<?php echo $uBD[2]; ?>');
                        $("select[name='month']").val('<?php echo $uBD[1]; ?>');
                        $("select[name='year']").val('<?php echo $uBD[0]; ?>');
                    </script>
                </td>
            </tr>
        </table>
        <div class="footer form">
            <input type="button" value="Cancel" />
            <input type="submit" value="Save" />
        </div>
        </form>
    </div>

    <div id="contactP" class="formP" style="display:none;">
        <form>
            <div class="h" style="background: #77BC78;"><?php eTR('contact_info'); ?><img class="close" src="images/close2.png" /></div>
            <table border="0" class="form">
                <tr>
                    <td><?php eTR("phone"); ?></td>
                    <td><input type='text' value='<?php echo $user[9]; ?>' placeholder="<?php eTR("phone"); ?>" name="phone" /></td>
                </tr>
                <tr>
                    <td><?php eTR("email_adress"); ?></td>
                    <td><input type='text' value='<?php echo $user[1]; ?>' placeholder="<?php eTR("email_adress"); ?>" name="email" /></td>
                </tr>
                <tr>
                    <td><?php eTR("adress"); ?></td>
                    <td><textarea name="adress" placeholder="<?php eTR("adress"); ?>" ><?php echo Br($user[10]); ?></textarea></td>
                </tr>
                <tr>
                    <td><?php eTR("country"); ?></td>
                    <td><input type='text' value='<?php echo $user[12]; ?>' placeholder="<?php eTR("country"); ?>" name="country" /></td>
                </tr>
                <tr>
                    <td><?php eTR("city"); ?></td>
                    <td><input type='text' value='<?php echo $user[13]; ?>' placeholder="<?php eTR("city"); ?>" name="city" /></td>
                </tr>
            </table>
            <div class="footer form">
                <input type="button" value="Cancel" />
                <input type="submit" value="Save" />
            </div>
        </form>
    </div>

    <div id="workP" class="formP" style="display:none;">
        <form>
            <div class="h" style="background: #77BC78;"><?php eTR('work'); ?><img class="close" src="images/close2.png" /></div>
            <table border="0" class="form">
                <tr>
                    <td><?php eTR("occupation"); ?></td>
                    <td><input type='text' value='<?php echo $user[6]; ?>' placeholder="<?php eTR("occupation"); ?>" name="occupation" /></td>
                </tr>
                <tr>
                    <td><?php eTR("skills"); ?></td>
                    <td><textarea placeholder="<?php eTR("skills"); ?>" name="skills"><?php echo Br($user[7]); ?></textarea>  </td>
                </tr>
                <tr>
                    <td><?php eTR("employement"); ?></td>
                    <td><textarea name="employement" placeholder="<?php eTR("employement"); ?>" ><?php echo Br($user[11]); ?></textarea></td>
                </tr>
            </table>
            <div class="footer form">
                <input type="button" value="Cancel" />
                <input type="submit" value="Save" />
            </div>
        </form>
    </div>

    <div id="settP" class="formP" style="display:none; width:auto; height:auto;">
            <div class="h" style="background: #77BC78;"><?php eTR('account_sett'); ?><img class="close" src="images/close2.png" /></div>
            <table border="0" class="form">
                <tr>
                    <td colspan="2">
                        <form id="passwordForm" style="">
                            <table border="0" class="form" style="padding:0;">
                                <tr>
                                    <td><?php eTR("old_pass"); ?>:</td>
                                    <td><input type="password" name="oldpass" placeholder="<?php eTR("old_pass"); ?>" /></td>
                                </tr>
                                <tr>
                                    <td><?php eTR("new_pass"); ?>:</td>
                                    <td><input type="password" name="newpass" placeholder="<?php eTR("new_pass"); ?>" /></td>
                                </tr>
                                <tr>
                                    <td><?php eTR("new_pass_again"); ?>:</td>
                                    <td><input type="password" name="newpassagain" placeholder="<?php eTR("new_pass_again"); ?>" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="">
                                        <input type="submit" value="<?php eTR("save"); ?>" />
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </td>
                </tr>
                <tr>
                    <td><?php eTR("change_avatar"); ?></td>
                    <td>
                        <form id="uploadAvatarForm">
                            <table border="0" class="form" style="padding:0;">
                                <tr>
                                    <td colspan="2"><input type="file" name="img"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" class="uploadB" value="" id="uploadImgBtn" style="display:none" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div id="tmpAvatar" style="display:none">
                            <img id="tmpImg" style="max-width: 100px; max-height:100px; cursor:zoom-in; padding:3px; margin:5px; background:#777; border-radius:2px;" onclick="previewImage(bigImg);"/>
                            <br><input type="button" id='saveCrtAvatar' value="<?php eTR('save'); ?>" />
                        </div>
                    </td>
                </tr>
            </table>
            <div class="footer form">
                <input type="button" value="Cancel"/>
            </div>
    </div>
    </div>
</div>
<script>
    var crtP;
    $('.hover1').click(function(){
        $('.hover1').fadeOut();
        $('.PContainer').fadeOut();
        crtP.slideUp();
    });
    $('.PContainer').click(function(event){
        if($(event.target).attr('class')!="hover2")return;
        $('.hover1').click();
    });
    $('.close').click(function(){
        $('.hover1').click();
    });
    $('.footer input:first-child').click(function(){
        $('.hover1').click();
    });

    function dH(){
        $('.hover1').fadeIn();
        $('.PContainer').fadeIn();
    }

    $("#basicInfoP").on('submit', function(e){
        e.preventDefault();
        var str=$(this).children().first().serialize();
        $("#basicInfoP input").disable();
        $("#basicInfoP select").disable();
        ajaxN("fn=uupdateBI&"+str, updating_pw, "", function(ret){
            $("#basicInfoP input").enable();
            $("#basicInfoP select").enable();
            if(ret['status']=='success')
                $('.hover1').click();
        });
    });
    $("#contactP").on('submit', function(e){
        e.preventDefault();
        var str=$(this).children().first().serialize();
        $("#contactP input").disable();
        $("#contactP textarea").disable();
        ajaxN("fn=uupdateCI&"+str, updating_pw, "", function(ret){
            $("#contactP input").enable();
            $("#contactP textarea").enable();
            if(ret['status']=='success')
                $('.hover1').click();
        });
    });
    $("#workP").on('submit', function(e){
        e.preventDefault();
        var str=$(this).children().first().serialize();
        $("#workP input").disable();
        $("#workP textarea").disable();
        ajaxN("fn=uupdateWI&"+str, updating_pw, "", function(ret){
            $("#workP input").enable();
            $("#workP textarea").enable();
            if(ret['status']=='success')
                $('.hover1').click();
        });
    });
    $("#passwordForm").on('submit', function(e){
        e.preventDefault();
        var str=$(this).serialize();
        $("#passwordForm input").disable();
        ajaxN("fn=uChPass&"+str, updating_pw, "", function(ret){
            $("#passwordForm input").enable();
            if(ret['status']=='success')
                $("#changePassCancelBtn").click();
        });
    });
    $("#uploadAvatarForm").on('submit', function(e){
        e.preventDefault();
        var note=newNotification('loading', 'Uploading image...', 'Please wait...', -1);
        ajaxForm(new FormData(this), function(ret){
            reNotification(note, ret['status'], ret['html'], '', 7500);
            if(ret['status']=='success')
                $("#changeAvatarCancelBtn").click();
        }, "uUplImg");
    });
    $("#saveCrtAvatar").click(function(){
        ajaxN("fn=uconfirmTmpAvatar", updating_pw, "", function(ret){
            if(ret['status']='success'){
                $("#profileImg").attr('src', ret['small']).unbind('click').click(function(){
                    previewImage(ret['big']);
                });
                $("#tmpAvatar").slideUp();
                var input = $("input[name='img']");
                input.replaceWith(input.val('').clone(true));
                $("#uploadImgBtn").slideUp();
            }
        });
    });
    $("input[name='img']").on('change', function(){
        $("#uploadImgBtn").slideDown();
    });
</script>
<?php
    $ee=isset($_REQUEST['eid']);
    if($ee)
        $eid=$_REQUEST['eid'];

    if($ee){
        require_once("inc/php/mysqli.php"); global $conn;
        require_once("inc/php/funcs.php");
        $e=$conn->Row("SELECT * from event where id=?;", array($eid));
        $date=date("Y/m/d", strtotime($e[4])); $date=explode('/', $date);

        $small="images/event/".$eid."_small.".$e[6];
        $big="images/event/".$eid."_big.".$e[6];
        $small=file_exists($small)?$small:"";
        $big=file_exists($big)?$big:"";
    }
?>

<h2><?php echo !$ee?"Create":"Edit"; ?> Event</h2>
<form id="ceForm">

        <table border="0" class="form">

            <tr>
                <td>Name</td>
                <td><input type='text'  name="name" value="<?php echo $ee?$e[1]:""; ?>"/></td>
            </tr>
            <tr>
                <td>Ticket price</td>
                <td><input type='text'  name="price" value="<?php echo $ee?$e[3]:""; ?>"/></td>
            </tr>
            <tr>
                <td>Location</td>
                <td><input type='text'  name="location" value="<?php echo $ee?$e[2]:""; ?>"/></td>
            </tr>
            <tr>
                <td>Coordonate <br>pentru harta <a id="coordQ">(?)</a></td>
                <td><input type='text'  name="lati" value="<?php echo $ee?$e[8]:""; ?>" placeholder="Latitude"/><br>
                    <input type='text'  name="long" value="<?php echo $ee?$e[9]:""; ?>" placeholder="Longitude"/>
                </td>
            </tr>
            <tr>
                <td>Date</td>
                <td>
                    <?php
                        $y=date('Y', time());
                    ?>
                    <select name="day" ><?php for($i=1;$i<32;$i++) echo "<option value='$i' >$i</option>\n"; ?></select>
                    <select name="month"> <?php for($i=1;$i<13;$i++) echo "<option value='$i' >$i</option>\n"; ?></select>
                    <select name="year"> <?php for($i=$y;$i<$y+10;$i++) echo "<option value='$i' >$i</option>\n"; ?></select>
                    <?php if($ee){ ?>
                    <script>
                        $("select[name='day']").val(<?php echo $date[2]; ?>);
                        $("select[name='month']").val(<?php echo $date[1]; ?>);
                        $("select[name='year']").val(<?php echo $date[0]; ?>);
                    </script>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>More info</td>
                <td><textarea name="info" ><?php echo $ee?$e[5]:""; ?></textarea></td>
            </tr>
            <tr>
                <td>Cover Photo</td>
                <td>
                        <table border="0" class="form" style="padding:0;">
                            <tr>
                                <td colspan="2" id="tralala"><input type="file" name="img" id="imgInput"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="button" class="uploadB" id="uploadImgBtn" style="display:none" />
                                </td>
                            </tr>
                        </table>
                    <div id="tmpAvatar" style="display:none">
                        <img id="tmpImg" style="max-width: 100px; max-height:100px; cursor:zoom-in; padding:3px; margin:5px; background:#777; border-radius:2px;" onclick="previewImage(bigImg);"/>
                        <input type="hidden" name="imgFromTmp" value="1" disabled="disabled"/>
                    </div>
                </td>
            </tr>

        </table>
        <div class="footer form">
            <input type="submit" value="Save" />
        </div>
</form>

<form id="uploadImgForm" style="display:none;">
</form>
<script>
    $("#ceForm").on("submit", function(e){
        e.preventDefault();
        var str=$(this).serialize();
        <?php if($ee) echo "str+='&eid=$eid';\n"; ?>
        var th;
        (th=$(this)).disable();
        ajaxN("fn=aCreateEvent&"+str, '', please_wait, function(ret){
            th.enable();
            $("input[name='imgFromTmp']").disable();
            if(ret['status']=='success' && !ee)
            {
                return;
                th.clearVals();
                $("input[name='imgFromTmp']").disable();
                $('#tmpAvatar').slideUp();
                $("select[name='day']").val($("select[name='day'] option:first").val());
                $("select[name='year']").val($("select[name='year'] option:first").val());
                $("select[name='month']").val($("select[name='month'] option:first").val());
            }
        });
    });
    $("input[name='img']").on('change', function(){
        $("#uploadImgBtn").slideDown();
        $('#tmpAvatar').slideUp();
        $("input[name='imgFromTmp']").disable();
    });

    $("#uploadImgBtn").click(function(){
        $("#imgInput").appendTo($("#uploadImgForm"));
        $('#tmpAvatar').slideUp();
        $("#uploadImgForm").submit();
    });

    $("#uploadImgForm").on('submit', function(e){
        e.preventDefault();
        var note=newNotification('loading', 'Uploading image...', please_wait, -1);
        var fdata=new FormData(this);
        fdata.append("fn", "")
        $("input[name='imgFromTmp']").disable();
        ajaxForm(fdata, function(ret){
            reNotification(note, ret['status'], ret['html'], '', 7500);
            if(ret['status']=='success')
                $("input[name='imgFromTmp']").enable().val(ret['ext']);
            $("#imgInput").appendTo($("#tralala"));
        }, "aEventImgUp");
    });
    $("#coordQ").click(function(){
        alertify.alert("");
    });
    var ee=false;
    <?php if($ee && $small && $big) { ?>
    $('#tmpImg').attr('src', '<?php echo $small; ?>');
    $('#tmpAvatar').slideDown();
    bigImg='<?php echo $big; ?>';
    ee=true;
    <?php } ?>
</script>
<style>
    .form input[type="button"].uploadB{
        background-image: url("images/upload1.png");
        background-size:100% 100%;
        background-color:transparent;
        width:40px;
        height:40px;
        opacity:0.6;
    }
    .form input[type="button"].uploadB:hover{
        opacity:1;
    }
</style>
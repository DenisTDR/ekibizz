<h2><?php eTR("share_your_bizz_idea"); ?></h2>
<div class="mid">
    <form id='tf'>
    <table class="form">
        <tr>
            <td><?php eTR("title"); ?></td>
            <td><input type="text" name="title" placeholder="<?php eTR("title"); ?>" style="width:250px"/></td>
        </tr>
        <tr>
            <td><?php eTR("desc"); ?></td>
            <td><textarea name="desc" placeholder="<?php eTR("desc"); ?>"></textarea></td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" id="sendBtn" value="<?php eTR("send"); ?>" id="sendBtn"/></td>
        </tr>
    </table>
    </form>
    <div class="hidden" id="requestStatusDiv">

    </div>
</div>
<script>
    $("#tf").on('submit', function(e){

        e.preventDefault();
        var str=$(this).serialize();
        $("#tf input, #tf textarea").disable();
        var note=newNotification('loading', please_wait, "", -1);
        ajax("fn=ubizz_idea&"+str, function(ret){
            reNotification(note, ret['status'], ret['html'], "", 5000);
            $("#tf input, #tf textarea").enable();
            if(ret['status']=='success')
                $("#tf input[type='text'], #tf textarea").val("");
        });

        return;
        var title=$("input[name='title']").val();
        var desc=$("textarea[name='desc']").val();

        var rezDiv=$("div#requestStatusDiv");
        rezDiv.attr("class", "loading");
        rezDiv.html("<?php eTR("sending_request");?>");

        ajax("fn=ubizz_idea&title="+title+"&desc="+desc, function(ret){
            rezDiv.attr("class", ret['status']);
            if(ret['status']=='error')
                rezDiv.html(ret['error']);
            else
                rezDiv.html(ret['html']);
        });
    });

</script>
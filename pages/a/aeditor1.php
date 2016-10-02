<script>
    var pressed=false;
    try{
        tinymce.remove();
    }catch(exc) {}
    tinymce.init({
        selector: "textarea#theTextarea",
        theme: "modern",
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor ink image | print preview fullscreen save",

        save_onsavecallback: function() {
            if(ttxt.val().startsWith('<p>'))
                ttxt.val(ttxt.val().substring(3, ttxt.val().length-4 ));
            if(!pressed)$("#theForm").trigger('submit');
        },

        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu template paste textcolor"
        ]
    });
</script>
<div class="form" style="text-align:left;">
    <select id="langSel2">
        <option value="en">En</option>
        <option value="ro">Ro</option>
        <option value="tr">Tr</option>
    </select>
    <input type="text" readonly="readonly" value="abc" id="keyTxt" />
</div>
<form id="theForm" class="form">
    <textarea id="theTextarea" name="val"><?php
            $p=&$_REQUEST;
            if(isset($p['lang']) && isset($p['key'])){
                $lang=$p['lang']; $key=$p['key'];
                require_once("inc/php/mysqli.php"); global $conn;
                $lang=$conn->EscapeString($lang);
                $x=$conn->Value("SELECT $lang from translate where `key`=?;", array($key));
                $x=deSanitize($x);
                echo $x;
            }
            else
                echo "Nothing found to edit!";
        ?></textarea>
    <input type="submit" id="updateBtn" value="Save" />
    <input type="button" id="previewBtn" value="Preview down" />
    <input type="button" value="Back" id="backBtn" />
</form>
<script>

    $("#theForm").on('submit', function(e){
        e.preventDefault();
        pressed=true;
        $(".mce-ico.mce-i-save").click();
        pressed=false;
        if(ttxt.val().startsWith('<p>'))
            ttxt.val(ttxt.val().substring(3, ttxt.val().length-4 ));
        var str=$(this).serialize();
        str+="&key="+key+"&col="+lang;
        ajaxN("fn=aupdateTR&"+str, "", please_wait, function(ret){

        });
    });
    $("#previewBtn").on('click', function(){
        pressed=true;
        $(".mce-ico.mce-i-save").click();
        $("#previewDiv").html(ttxt.val());
        pressed=false;
    });

    var ttxt=$("#theTextarea");
    var lang="", key="";
    if(getUrlVars()['lang'])
        $("#langSel2").val(lang=String(getUrlVars()['lang']));
    if(getUrlVars()['key'])
        $("#keyTxt").val(key=String(getUrlVars()['key']));
    $("#langSel2").on('change', function(){
        var key=getUrlVars()['key'];
        if(key)
            gotoPage("aeditor1&key="+key+"&lang="+$(this).val());
    });
    $("#backBtn").click(function(){
        if(window.lastTrLink)
            gotoPage(window.lastTrLink);
        else
            parent.history.back();
    });
    //setTimeout(function(){
        //$("#theTextarea").slideDown(1);
    //}, 1000);
</script>
<div id="previewDiv" style="">

</div>
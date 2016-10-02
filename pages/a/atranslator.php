<?php
    if(!isset($_SESSION['logged']) || !isset($_SESSION['admin'])){
        echo "<div class='error'>".TR('error_403')."</div>";
        return;
    }
?>
<style>
    table.translator{
        text-align:center;

        display:inline-block;
    }
    table.translator
     {
         border-collapse:collapse;
     }
    table.translator, .translator th, .translator tr
    {
        border: 1px solid #555;
    }
    table.translator textarea{
        width:150px;
        height: 75px;
        min-width: 100px;
        min-height: 50px;
    }
    table.translator textarea:disabled{
        opacity:0.5;
    }
    table.translator input[type='text']{

    }
    .translator td>div{
        position:relative;
    }
    .hDiv{
        padding:15px;
    }
    .hDiv label{
        padding:15px 15px 15px 0
    }
    .fullBtn{
        background-image: url('images/fullscr1.png');
        background-size: 100% 100%;
        width:20px;
        height:20px;
        opacity:0.6;
        cursor:pointer;
        position:absolute;
        top:3px;
        right:3px;
    }
    .fullBtn:hover{
        opacity: 1;
    }

</style>
<?php
    require_once("inc/php/mysqli.php");
    global $conn;
    $cols=$conn->Columns("translate");
    $c=$conn->Count("Select Count(*) from translate");
    $page=isset($_REQUEST['page'])?$_REQUEST['page']:0;
    $len=isset($_REQUEST['len'])?$_REQUEST['len']:20;
    function replaceBR($str){
        return str_replace("<br>", "\n", $str);
    }
?>

<div class="mid form" >
    <div class="hDiv">
        <?php
            for($i=0;$i<sizeof($cols); $i++)
                echo '<input type="checkbox" class="'.$cols[$i].'" id="'.$cols[$i].'" checked="checked"/><label for="'.$cols[$i].'">'.ucfirst($cols[$i]).'</label>';
        ?>

        <br>
        Rows on page:
        <select class="lenSel">
        <?php
            $lens=array(5, 10, 20, 30, 50, 75, 100);
            for($i=0;$i<sizeof($lens);$i++)
                echo "<option value='".$lens[$i]."' ".($len==$lens[$i]?"selected='selected'":"").">".$lens[$i]."</option>";
        ?>
        </select>
        <br>
        Page:
        <?php
            $offset=$len*$page;
            $pn=$_REQUEST['pn'];
            for($i=0;$i<$c/$len;$i++)
                echo "<a onclick=\"gotoUPage('atranslator&len=$len&page=$i');\" class='pageHref ".($i==$page?"active":"")."'>".($i+1)."</a>  ";
        ?>
    </div>
    <table class="translator" id="translator" border="1">

            <?php
                $rows=$conn->Rows("SELECT id, `key`, en, tr, ro, note from translate LIMIT ?, ?;", array($offset, $len));
                $cc=0;
                while($row=$rows->nextRow()){
                    if($cc%10==0){
                        echo "<tr>";
                            for($i=0;$i<sizeof($cols); $i++)
                                echo "<td class='".$cols[$i]."TD'>".ucfirst($cols[$i])."</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    for($i=0;$i<sizeof($cols); $i++){
                        echo "<td class='".$cols[$i]."TD'>";
                        if($i==0)
                            echo $row[0];
                        else if($i==1)
                            echo "<input type='text' readonly='readonly' value='$row[1]' />";
                        else
                            echo "<div><textarea>".replaceBR($row[$i])."</textarea></div>";
                        echo "</td>";
                    }
                    echo "</tr>";
                    $cc++;
                }
            ?>
    </table>
    <div class="hDiv">

        Rows on page:
        <select class="lenSel">
            <?php
            $lens=array(5, 10, 20, 30, 50, 75, 100);
            for($i=0;$i<sizeof($lens);$i++)
                echo "<option value='".$lens[$i]."'".($len==$lens[$i]?"selected='selected'":"").">".$lens[$i]."</option>";
            ?>
        </select>
        <br>
        Page:
        <?php
        $offset=$len*$page;
        $pn=$_REQUEST['pn'];
        for($i=0;$i<$c/$len;$i++)
            echo "<a onclick=\"gotoUPage('atranslator&len=$len&page=$i');\" class='pageHref ".($i==$page?"active":"")."'>".($i+1)."</a>  ";
        ?>
    </div>
</div>
<script>

    <?php
        for($i=0;$i<sizeof($cols); $i++)
            echo "$('.".$cols[$i]."').change(function(){\$('.".$cols[$i]."TD').toggle();});\n";
    ?>

    var cols=new Array(
               <?php
                   echo "'".$cols[0]."'";
                   for($i=1;$i<sizeof($cols); $i++)
                       echo ', \''.$cols[$i].'\'';
               ?>
               );

    var txts=$("td:nth-child(3) textarea, td:nth-child(4) textarea, td:nth-child(5) textarea");
    for(var i=0;i<txts.length;i++)
    {
        var btn=$("<div>&nbsp;</div>");
        btn.addClass('fullBtn');
        txts.nTh(i).parent().append(btn);
    }

    $('.fullBtn').click(function(){
        var parent=$(this).parent().parent().parent();
        var key=$($(parent.children()[1]).children()[0]).val();
        var col=cols[$(this).parent().parent().index()];
        window.lastTrLink="atranslator&len=<?php echo $len; ?>&page=<?php echo $page; ?>";
        gotoPage("aeditor1&key="+key+"&lang="+col);
    });

    $("textarea").change(function(){

        var th=this;
        var parent=$(this).parent().parent().parent();

        var key=$($(parent.children()[1]).children()[0]).val();
        var col=cols[$(this).parent().parent().index()];
        var value=$(this).val();

        $(this).attr("disabled", "disabled");
        var tn=newNotification('loading', "Updating "+col+" for "+key+"...", 'Updating translation', 15000 )


        ajax("fn=aupdateTR&key="+key+"&col="+col+"&val="+value, function(ret){
            reNotification(tn, ret['status'], ret['html'], 'Translation updated!', 5000 );
            $(th).removeAttr("disabled");
        });
    });
    $(".lenSel").change(function(){
        var len=$(this).val();
        gotoUPage('atranslator&len='+len+'&page=0');

        //window.location="?pn="+getUrlVars()['pn']+"&len="+val+"&page=0";
    });
</script>


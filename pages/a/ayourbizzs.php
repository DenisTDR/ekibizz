<h3><?php eTR("share_your_bizz_idea") ?></h3>
<div class='form mid'>

<?php
    $page=isset($_REQUEST['p'])?$_REQUEST['p']:0;
    $length=isset($_REQUEST['l'])?$_REQUEST['l']:3;
    require_once("inc/php/mysqli.php"); global $conn;
    $count=$conn->Count("SELECT COUNT(*) from bizz_idea;");

    //echo "Page: $page ---  Length: $length  ----  Count: $count<br><br>";

    $pc=$count/$length; $pc=$pc==intval($pc)?$pc:intval($pc)+1;
?>
    Rows on page:
    <select class="lenSel">
        <?php
        $lens=array(3, 5, 7, 10, 20, 30, 50, 75, 100);
        for($i=0;$i<sizeof($lens);$i++)
            echo "<option value='".$lens[$i]."' ".($length==$lens[$i]?"selected='selected'":"").">".$lens[$i]."</option>";
        ?>
    </select><br>
<?php
    for($i=0; $i<$pc; $i++)
        echo "<a class='pageHref ".($i==$page?"active":"")."' onclick='gotoUPage(\"ayourbizzs&l=$length&p=$i\"); return false;'  >".($i+1)."</a>";
    $page=intval($page); $length=intval($length);
    $rows=$conn->Rows("SELECT idea.*, acc.`name` FROM `bizz_idea` AS idea "
                        ."JOIN account AS acc WHERE acc.id = idea.sender limit ".($page*$length).", ".$length.";");

?>
    <br>
    <table style="text-align:center; display:inline-block;" border="1">
        <tr>
            <td>Id</td>
            <td>Sender</td>
            <td>Title</td>
            <td>Idea</td>
            <td>Status</td>
        </tr>
        <?php
            while($row=$rows->nextRow()){
                $row[3]=str_replace("\\n", "&#10;", $row[3]);
                echo"<tr>";
                echo"<td>$row[0]</td><td>$row[5]</td><td>$row[2]&nbsp;</td><td><textarea readonly='readonly'>$row[3]</textarea></td><td>$row[4]</td>";
                echo"</tr>\n";
            }
        ?>
    </table>

</div>
<script>
    $(".lenSel").change(function(){
        var len=$(this).val();
        gotoUPage('ayourbizzs&l='+len+'&p=0');
    });
</script>
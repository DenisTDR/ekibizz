<h3><?php eTR("training_location") ?></h3>
<div class='form mid'>

<?php
    $page=isset($_REQUEST['p'])?$_REQUEST['p']:0;
    $length=isset($_REQUEST['l'])?$_REQUEST['l']:3;
    require_once("inc/php/mysqli.php"); global $conn;
    $count=$conn->Count("SELECT COUNT(*) from location_request;");

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
        echo "<a class='pageHref ".($i==$page?"active":"")."' onclick='gotoUPage(\"alocationrequest&l=$length&p=$i\"); return false;'  >".($i+1)."</a>";
    $page=intval($page); $length=intval($length);
    $rows=$conn->Rows("SELECT * FROM location_request limit ".($page*$length).", ".$length.";");

?>
    <br>
    <table style="text-align:center; display:inline-block;" border="1">
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Age</td>
            <td>Profession</td>
            <td>Email</td>
            <td>Phone</td>
        </tr>
        <?php
            while($row=$rows->nextRow()){
                $row[3]=str_replace("\\n", "&#10;", $row[3]);
                echo"<tr>";
                echo"<td>$row[0]</td><td>$row[1]</td><td>$row[2]&nbsp;</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td>";
                echo"</tr>\n";
            }
        ?>
    </table>

</div>
<script>
    $(".lenSel").change(function(){
        var len=$(this).val();
        gotoUPage('alocationrequest&l='+len+'&p=0');
    });
</script>
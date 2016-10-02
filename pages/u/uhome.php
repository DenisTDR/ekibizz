<style>
    table.clientsTable{
        width:500px;
        text-align: center;
        margin:0 auto;
        font-size:1.2em;
    }
    .clientsTable td a img{
        width:35px;
    }
    .clientsTable td a{
        opacity: 0.7;
    }
    .clientsTable td a:hover{
        opacity: 1;
    }
</style>
<div class="mid">
    <?php
        require_once("inc/php/mysqli.php");global $conn;
        $clientOf=$conn->Value("SELECT clientOf from account where idnumber=?;", array($_SESSION['loggedIdNr']));
        if($clientOf && $clientOf!=-1)
        {
            $mentor=$conn->Value("SELECT name from account where idnumber=?;", array($clientOf));
            echo "<h3>You are client of $mentor [$clientOf]</h3>";
        }
    ?>
</div>

<?php
    unset($_SESSION['logged']);
    unset($_SESSION['loggedId']);
    unset($_SESSION['admin']);

?>
<div class="success">
    <?php eTR('log_out_message'); ?>
</div>
<script>
    setTimeout(function(){
        window.location="?pn=homep";
    }, 1000);
</script>
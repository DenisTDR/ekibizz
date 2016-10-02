<h2><?php eTR('create_account'); ?></h2>
<form id="createAccountForm">
    <table class="mid form">
        <tr>
            <td><?php eTR('ebo_id'); ?>:</td>
            <td><input type="text" placeholder="<?php eTR('ebo_id'); ?>" name="id" /></td>
        </tr>
        <tr>
            <td><?php eTR('name'); ?>:</td>
            <td><input type="text" placeholder="<?php eTR('name'); ?>" name="name" /></td>
        </tr>
        <tr>
            <td><?php eTR('user'); ?>:</td>
            <td><input type="text" placeholder="<?php eTR('user'); ?>" name="user" /></td>
        </tr>
        <tr>
            <td><?php eTR('password'); ?>:</td>
            <td><input type="password" placeholder="<?php eTR('password'); ?>" name="pass" /></td>
        </tr>
        <tr>
            <td><?php eTR('password_again'); ?>:</td>
            <td><input type="password" placeholder="<?php eTR('password_again'); ?>" name="passagain" /></td>
        </tr>
        <tr>
            <td><?php eTR('email_adress'); ?>:</td>
            <td><input type="text" placeholder="<?php eTR('email_adress'); ?>" name="email" /></td>
        </tr>
        <tr>
            <td>Client of:</td>
            <td>
                <select name="clientOf">
                    <option value="-1">none</option>
                    <?php
                        require_once("inc/php/mysqli.php"); global $conn;
                        $users=$conn->Rows("SELECT name, idnumber from account;");
                        while($user=$users->nextRow())
                            echo "<option value='$user[1]'>$user[1] - $user[0]</option>\n";
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input type="submit" value="<?php eTR('send'); ?>" /></td>
        </tr>
    </table>
</form>
<script>
    $("#createAccountForm").on('submit', function(e){
        e.preventDefault();
        var th=$(this);
        var str=th.serialize();
        th.disable();
        var aNote=newNotification("loading", "", "Creating account...", -1);
        ajax("fn=aCreateAccount&"+str, function(ret){
             reNotification(aNote, ret['status'], ret['html'], "", 3000);
             th.enable();
        });
    });
</script>
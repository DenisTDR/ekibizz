
<!--h1><?php eTR("login"); ?></h1>
<div class="mid">
    <form id="loginForm">
        <table class="form" style="margin:0 auto;">
            <tr><td><input type="text" name="user" placeholder="<?php eTR('user'); ?>" /></td></tr>
            <tr><td><input type="password" name="pass" placeholder="<?php eTR('password'); ?>" /></td></tr>
            <tr><td style="text-align: center;"><input type="submit" id="loginBtn" value="<?php eTR('login'); ?>" /></td></tr>
        </table>
    </form>
</div>
<script>
    $("#loginForm").on("submit", function(e){

    });
</script-->
<div class="container2">
    <div>
        <h2 class="form-signin-heading text-center">
            Are you ready do begin your business journal?
            <br>
            <small>This is the place where you learn about the business environment and you have the oportunity to make money</small>
        </h2>
        <div>
            <form class="form-signin" role="form">
                <input type="text" class="form-control" placeholder="user" name="user" required autofocus>
                <input type="password" class="form-control" placeholder="password" name="pass" required>
                <label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
                <a href="?" class="btn btn-lg btn-warning btn-block" onclick="gotoPage('homep'); return false;">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script>
    $(".form-signin").on('submit', function(e){
        e.preventDefault();
        var th=$(this);
        var str=th.serialize();
        th.disable();
        var note=newNotification('loading', please_wait, "", -1);
        ajax("fn=ulogin&"+str, function(ret){
            reNotification(note, ret['status'], ret['html'], "", 2000);
            th.enable();
        });
    });
</script>
<style>
    .container2{
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:#eee;
        z-index:10;
        display:table;
    }
    .container2>div{
        display:table-cell;
        vertical-align: middle;
    }
    .container2>div>div{
        width:350px;
        margin:0 auto;
        text-align:left;
    }
    .container2 h2{
        width:60%;
        margin:0 auto;
    }
</style>

<h1>Admin <?php eTR("settings"); ?></h1>
<div class="form asform">
    <table>
        <tr>
            <td>
                <h3>General:</h3>
                <input type="button" value="Translations" onclick="gotoUPage('atranslator')" />
            </td>
            <td>
                <h3>Requests:</h3>
                <input type="button" value="Bizz ideas" onclick="gotoUPage('ayourbizzs')" /><br>
                <input type="button" value="Bizz help requests" onclick="gotoUPage('abizzhelp')" /><br>
                <input type="button" value="Location requests" onclick="gotoUPage('alocationrequest')" />
            </td>
        </tr>
        <tr>
            <td>
                <h3>Events:</h3>
                <input type="button" value="List events" onclick="gotoPage('aevents')" /><br>
                <input type="button" value="Create event" onclick="gotoPage('acreateevent')" /><br>
                <input type="button" value="Event->Member" onclick="gotoPage('aeventmember')" />
            </td>
            <td>
                <h3>Users:</h3>
                <input type="button" value="Create account" onclick="gotoUPage('acreateaccount')" /><br>
                <input type="button" value="Users" onclick="gotoPage('ausers')" />
            </td>
        </tr>
    </table>
</div>
<style>
    .asform{
        text-align:left;
    }
    .asform table{
        margin:0 auto;
    }
    .asform td{
        vertical-align:top;
        padding:0 30px 15px 30px;
    }
    .asform input[type=button]{
        width: 100%;
    }
</style>
<h2>List events</h2>


<div class="form" style="text-align: left">
    <input type="button" value="<?php eTR('delete'); ?>" id="deleteEvBtn" />
    <table border="0" class="evTable">
        <thead>
        <tr>
            <td><input type="checkbox" id="allC" /></td>
            <td>Id</td>
            <td>Name</td>
            <td>Location</td>
            <td>Price</td>
            <td>Date</td>
            <td>Actions</td>
        </tr>
        </thead>
        <tbody>
        <?php
            require_once("inc/php/mysqli.php"); global $conn;
            $events=$conn->Rows("SELECT * from event where deleted=0;");
            while($event=$events->nextRow())
                echo "<tr><td><input type='checkbox'/></td>".
                    "<td>$event[0]</td>".
                    "<td>$event[1]</td>".
                    "<td>$event[2]</td>".
                    "<td>$event[3]</td>".
                    "<td>$event[4]</td>".
                    "<td><input type='button' value='".TR('edit')."'/>".
                    "<input type='button' value='".TR('view')."'/></td>"
                    ;

        ?>
        </tbody>
    </table>
</div>
<style>
    .evTable{
        width:100%;
    }
    .evTable thead td:first-child{
        width: 30px;
    }
    .evTable thead td:nth-child(2){
        width: 60px;
    }
</style>
<script>
    $(".evTable").colResizable({liveDrag:true});

    $('.evTable thead td:first-child, .evTable thead td:last-child').data("sorter", false);

    $('.evTable').tablesorter({
        widgets        : ['zebra', 'columns'],
        usNumberFormat : false,
        sortReset      : true,
        sortRestart    : true,
        theme		   : 'default'
    });
    $("#allC").on('change', function(){
        $(".evTable tbody input[type='checkbox']").prop('checked', this.checked);
        $("#deleteEvBtn").able(this.checked);
    });
    $(".evTable tbody input[type='checkbox']").on('change', function(){
        if(!this.checked)
            $("#allC").prop('checked', false);
        var chks=$(".evTable tbody input[type='checkbox']");
        var c=0;
        for(var i=0;i<chks.length;i++)
            c+=chks.nTh(i)[0].checked?1:0;
        if(c==chks.length)
            $("#allC").prop('checked', true);
        $("#deleteEvBtn").able(c>0);
    });
    $("#deleteEvBtn").disable().click(function(){
        alertify.set({
            labels : {
                ok     : "<?php eTR('yes'); ?>",
                cancel : "<?php eTR('no'); ?>"
            },
            delay : 5000,
            buttonReverse : false,
            buttonFocus   : "cancel"
        });
        alertify.confirm("<?php eTR('sure_delete_events'); ?>", function (e) {
            if(!e)return;
            var trs=$(".evTable tbody tr");
            var str="";
            for(var i=0; i<trs.length; i++){
                var tr=trs.nTh(i);
                var chk=tr.children().nTh(0).children().nTh(0);
                if(chk.prop('checked'))
                    str+="&td[]="+tr.data('eid');
            }
            $(".evTable input").disable();
            ajaxN("fn=adelev"+str, "", please_wait, function(ret){
                if(ret['status']=='success')
                    for(var i=0; i<trs.length; i++){
                        var tr=trs.nTh(i);
                        var chk=tr.children().nTh(0).children().nTh(0);
                        if(chk.prop('checked'))
                            tr.fadeOut(function(){
                                $(this).remove();
                            });
                    }
                $(".evTable input").enable();
            });
        });
        return false;
    });
    var trs=$(".evTable tbody tr");
    for(var i=0; i<trs.length; i++){
        var eid=trs.nTh(i).children().nTh(1).html();
        trs.nTh(i).data("eid", eid);
        trs.nTh(i).find(":last-child").children().nTh(0).click(function(){
            gotoPage('acreateevent&eid='+$(this).parent().parent().data('eid'));
        });
        trs.nTh(i).find(":last-child").children().nTh(1).click(function(){
            gotoPage('uevent&eid='+$(this).parent().parent().data('eid'));
        });


    }
</script>
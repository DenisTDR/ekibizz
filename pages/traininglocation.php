<!--p class="h1"><?php eTR("training_location");?></p>

<div style=" width:75%; display:inline-block; padding-left:50px">
    <p class="h3 left"><?php eTR("training_location_1");?></p>
    <form id="locationForm">
    <table class="form">
        <tr><td><input type="text" name="name" placeholder="<?php eTR("name"); ?>"/></td></tr>
        <tr><td><input type="text" name="age" placeholder="<?php eTR("age"); ?>"/></td></tr>
        <tr><td><input type="text" name="profession" placeholder="<?php eTR("profession"); ?>"/></td></tr>
        <tr><td><input type="text" name="email" placeholder="<?php eTR("email_adress"); ?>"/></td></tr>
        <tr><td><input type="text" name="phone" placeholder="<?php eTR("phone"); ?>"/></td></tr>
        <tr><td ><input type="submit" id="sendBtn" value="<?php eTR('send'); ?>" /></td></tr>
    </table>
    </form>
    <div class="hidden" id="requestStatusDiv">
        Div testing ABC!<br>
        dadadadad ad da da dada da dad
    </div>
</div-->
<header id="slider">
    <div class="tp-banner">
        <ul>
            <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                <img src="images/slider/4.png"  alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                <div class="tp-caption page-enter-caption-style lfb"
                     data-x="center"
                     data-y="bottom"
                     data-voffset="-50"
                     data-speed="800"
                     data-start="250"
                     data-easing="Power4.easeOut"
                     data-captionhidden="off"
                     style="z-index: 6">Training Location
                </div>
            </li>
        </ul>
    </div>
</header>

<section>
    <div class="container">
        <hr>
        <div class="row margin-top60">
            <div class="col-sm-12 text-center">
                <p>Unfortunately we have a limited number of seats  avaible at our seminars.</p>
                <p>Also you have to fit to the  EBO profile to become a member</p>
                <p>Write the required information and you will receive the information as soon as possible.</p>
            </div>
        </div>
        <hr>
        <div class="row margin-top60">
            <div class="col-sm-12 col-md-6 col-md-offset-3">
                <form id="locationForm">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" name="name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email address" name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Profession" name="profession">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Age" name="age">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone Number" name="phone">
                    </div>
                    <input type="submit" class="btn btn-default" value="Submit"/>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        $('.tp-banner').revolution({
            delay: 9000,
            startwidth: 1170,
            startheight: 300,
            hideThumbs: "off",
            hideTimerBar: "on",
            navigationType: "bullet",
            navigationArrows: "none",
            navigationStyle: "round-old"
        }).resize();
    });
    setTimeout(function(){
        var x=$(".tp-fullwidth-forcer");
        if(x.length>1)
            x.nTh(1).slideUp(50);
    }, 2000);
    $("#locationForm").on('submit', function(e){
        e.preventDefault();
        var th=$(this);
        var str=th.serialize();
        th.disable();

        ajaxN("fn=location_request&"+str, "", please_wait, function(ret){
            th.enable();
            if(ret['status']=='success')
                th.clearVals();
        });
    });
</script>
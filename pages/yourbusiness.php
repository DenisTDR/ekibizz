
<!--p class="h1"><?php eTR("your_bizz");?></p>


<div style=" width:75%; display:inline-block; padding-left:50px">
<p class="h2 left"><?php eTR("your_bizz_1");?></p>
<p class="h3 left"><?php eTR("write_us_and_describe_1");?></p>
<form id="sendYourBizzF">
    <table class="form">
        <tr><td><input type="text" name="name" placeholder="<?php eTR("name"); ?>"/></td></tr>
        <tr><td><input type="text" name="email" placeholder="<?php eTR("email_adress"); ?>"/></td></tr>
        <tr><td><input type="text" name="your_pos" placeholder="<?php eTR("your_position_in_firm"); ?>"/></td></tr>
        <tr><td><input type="text" name="bizz_desc" placeholder="<?php eTR("bizz_desc"); ?>"/></td></tr>
        <tr><td>
                <textarea name="how_can_we_help" rows="4" cols="40" placeholder="<?php eTR("how_can_we_help_you"); ?>"></textarea>
        </td></tr>
        <tr><td><input type="submit" id="sendBtn" value="<?php eTR('send'); ?>" /></td></tr>
    </table>
</form>
    <div class="hidden" id="requestStatusDiv">
        Div testing ABC!<br>
        dadadadad ad da da dada da dad
    </div>
</div>
<script>

</script-->
<header id="slider">
    <div class="tp-banner">
        <ul>
            <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                <img src="images/slider/6.jpg"  alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                <div class="tp-caption page-enter-caption-style lfb"
                     data-x="center"
                     data-y="bottom"
                     data-voffset="-50"
                     data-speed="800"
                     data-start="250"
                     data-easing="Power4.easeOut"
                     data-captionhidden="off"
                     style="z-index: 6">Your Business
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
                <p>We provide  efficient methods to create oportunities for your business in order to increase the profitability. EBO has a special technique to increase sales of your products or services without high expenses rate  in advertising or promotion.</p>
                <p>Write to us if you want to improve the outcome of your business</p>
            </div>
        </div>
        <hr>
        <div class="row margin-top60">
            <div class="col-sm-12 col-md-6 col-md-offset-3">
                <form id="sendYourBizzF">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" name="name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email address" name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Position in Firm" name="your_pos">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Business Desc" name="bizz_desc" >
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="How can we help you?" name="how_can_we_help"></textarea>
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
    setTimeout(function(){
        var x=$(".tp-fullwidth-forcer");
        if(x.length>1)
            x.nTh(1).slideUp(50);
    }, 250);

    $("#sendYourBizzF").on('submit', function(e){
        e.preventDefault();
        var th=$(this);
        var str=th.serialize();
        th.disable();
        ajaxN("fn=help_request&"+str, "", please_wait, function(ret){
            th.enable();
            if(ret['status']=='success')
                th.clearVals();
        });
    });
    });
</script>

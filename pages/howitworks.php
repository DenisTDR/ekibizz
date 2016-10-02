
<!--p class="h1"><?php eTR("how_it_works");?></p>
<p class="h2"><?php eTR("there_are_3_steps_1");?>:</p>
<div class="stepsCont">
<div class="p1"><div class="circle"><div>1</div></div>
    <p class="h3"><?php eTR("join_free_seminars");?></p>
    <?php eTR("join_free_seminars_content");?>
</div>
<div class="p1"><div class="circle"><div>2</div></div>
    <p class="h3"><?php eTR("get_your_account");?></p>
    <?php eTR("get_your_account_content");?>
</div>
<div class="p1"><div class="circle"><div>3</div></div>
    <p class="h3"><?php eTR("began_bizz_activity");?></p>
    <?php eTR("began_bizz_activity_content");?>
</div>
</div-->
<header id="slider">
    <div class="tp-banner">
        <ul>
            <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                <img src="images/slider/5.jpg"  alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                <div class="tp-caption page-enter-caption-style lfb"
                     data-x="center"
                     data-y="bottom"
                     data-voffset="-50"
                     data-speed="800"
                     data-start="250"
                     data-easing="Power4.easeOut"
                     data-captionhidden="off"
                     style="z-index: 6">How It Works
                </div>
            </li>
        </ul>
    </div>
</header>
<section>
    <div class="container">
        <hr>
        <div class="row margin-top60">
            <div class="col-md-4 col-sm-12 text-center">
                <h3>Step 1</h3>
                <h4>Join the free seminars</h4>
                <p>During the seminars you will have the posibility to develop your personal skills and  learn new techniques which will help you to become the businessman that you have dreamed</p>
                <img src="images/img/sitepic/P3-1.png" class="img-responsive center-block" alt="">
            </div>
            <div class="col-md-4 col-sm-12 text-center">
                <h3>Step 2</h3>
                <h4>Get your account</h4>
                <p>You will recive a personalized account which will allow you to use the EBO system</p>
                <p>The account that you will recive will be your EBO identity.</p>
                <img src="images/img/sitepic/P3-4.png" class="img-responsive center-block" alt="">
            </div>
            <div class="col-md-4 col-sm-12 text-center">
                <h3>Step 3</h3>
                <h4>Begin your business activity</h4>
                <p>Immediately after you received your account you can enjoy your EBO experience and start to make some money.</p>
                <img src="images/img/sitepic/P3-3.png" class="img-responsive center-block" alt="">
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
</script>

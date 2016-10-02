<!--div style="text-align:center;">
    <p class='h1'><?php echo TR("about_trainings"); ?></p>

    <p class='h2'><?php echo TR("you_dont_have_to_pay"); ?></p>
    <p class='h3'><?php echo TR("you_dont_have_to_pay_content"); ?></p>

    <p class='h2'><?php echo TR("develop_your_personal_skills"); ?></p>
    <p class='h3'><?php echo TR("develop_your_personal_skills_content"); ?></p>

    <p class='h2'><?php echo TR("learn_more_1"); ?></p>
    <p class='h3'><?php echo TR("learn_more_1_content"); ?></p>

    <p class='h2'><?php echo TR("have_fun_1"); ?></p>
    <p class='h3'><?php echo TR("have_fun_1_content"); ?></p>

</div-->
<header id="slider">
    <div class="tp-banner">
        <ul>
            <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                <img src="images/slider/3.png"  alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                <div class="tp-caption page-enter-caption-style lfb"
                     data-x="center"
                     data-y="bottom"
                     data-voffset="-50"
                     data-speed="800"
                     data-start="250"
                     data-easing="Power4.easeOut"
                     data-captionhidden="off"
                     style="z-index: 6">About Trainings
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
                <h3>You don’t have to pay for seminars</h3>
                <p>There is no charge for the persons interested of EBO, all you have to do is to participate at the seminars and have a responsible behavior</p>
            </div>
            <div class="col-sm-12 text-center">
                <a href="#"><img src="images/img/sitepic/P2-2.png" class="img-responsive center-block" alt=""></a>
            </div>
            <div class="col-sm-12 text-center">
                <h3>Develop your personal skills</h3>
                <p>We provide all the material that you need which will  increase your capacity to react in the business environment. </p>
                <p>Seminars will help you to develop your ability to comunicate with others. If you want to be a businessman you have to interact with a lot of people so you need to be a natural speaker, a talanted orator with a lot of power in your voice.</p>
                <p>You will  learn how establish relationship within business environment.</p>
            </div>
            <hr>
            <div class="col-md-6 col-sm-12 text-center">
                <a href="#"><img src="images/img/sitepic/P2-3.png" class="img-responsive center-block" alt=""></a>
                <h3>Learn more about the business environment</h3>
                <p>There are some special techniques which will help you to succeed in your business activity.</p>
                <p>At the  seminars you will learn how to deal with difficulties from real life so you will not be surprised when it will appear a problem in your business.</p>
                <p>It will be easy for you to handle with any impasse because you will have the knowledge and skills learned from EBO seminars.</p>
            </div>
            <div class="col-md-6 col-sm-12 text-center">
                <a href="#"><img src="images/img/sitepic/P2-4.png" class="img-responsive center-block" alt=""></a>
                <h3>Have fun and make money</h3>
                <p>If you you obtained your EBO account all you need to do is begin your business activity.</p>
                <p>You will work at a multitude of projects and you will be rewarded for your effort.</p>
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

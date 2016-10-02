function reTopContent(){
    if(reTopping)return;
    reTopping=true;
    setTimeout(function(){
        $("#contentDiv").css('margin-top', $(".navbar.navbar-default").css('height'));
        console.log('retopped');
        reTopping=false;
    }, 1000)
}
var reTopping=false;
$(function() {
/*    $('.tp-banner').revolution({
        delay: 9000,
        startwidth: 1170,
        startheight: 300,
        hideThumbs: "off",
        hideTimerBar: "on",
        navigationType: "bullet",
        navigationArrows: "none",
        fullWidth: "on",
        forceFullWidth: "on",
        navigationStyle: "round-old"
    }).resize();
*/
    $(".langUl a").click(function(){
        changeLanguage($(this).attr('data-lang'));
    });
    $('#top').css({
        height: window.innerHeight,
        background: 'url("' + $('#top').data('img') + '") no-repeat center center',
        backgroundSize: '100% ' + window.innerHeight + 'px'
    });

    $(window).resize(function () {
        $('#top').css({
            height: window.innerHeight,
            backgroundSize: '100% ' + window.innerHeight + 'px'
        });
        reTopContent();
    });
    reTopContent();

    $('#inasagi').click(function(event) {
        event.preventDefault();
        $('#top').slideUp(500);
        $("#contentDiv").slideDown(1000);
    });



    var durum = true;

    if ($(window).scrollTop() >= window.innerHeight) {
        $('#top').hide(1);
        $('nav').addClass('navbar-fixed-top');

        durum = false;
    }

    if (durum) {
        $('#yuhari').addClass('calistir');
    }

    if ($(window).scrollTop() > 10) {
        $('#yuhari').fadeIn(400);
    } else {
        $('#yuhari').fadeOut(400);
    }

        /*
    $(window).scroll(function(e) {
        if (durum && $(window).scrollTop() >= window.innerHeight) {
            durum = false;
            setTimeout(function() {
                $('nav').addClass('navbar-fixed-top');
                $('html, body').animate({
                    scrollTop: 1
                }, 500, 'easeInOutCirc', function() {
                    setTimeout(function() {
                        $('#yuhari').removeClass('calistir');
                    }, 100)
                });
            }, 375);
        }

        if ($(window).scrollTop() > 10) {
            $('#yuhari').fadeIn(400);
        } else {
            $('#yuhari').fadeOut(400);
        }
    });
    */
});
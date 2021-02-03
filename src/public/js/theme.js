$(function () {
    let menu=$('.menu');

    $('.card-head').on('click',function(){
        $(this).next().slideToggle('slow');
    });

    function showMenu() {
        $(menu).animate({
            width: "350"
        }, 500);
    }

    function hideMenu() {
        $(menu).animate({
            width: "61px"
        }, 500);
    }

    $('#menu-btn').on('click',function () {
        if ($(menu).hasClass('showed')) {
            hideMenu();
        } else {
            showMenu();
        }
        $('#menu-btn').toggleClass('open');
        $(menu).toggleClass('showed');
    });

    window.setTimeout(function () {
        $(".alert-hide").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 5000);

    function changeMenu(){
        if ($(menu).prop('offsetHeight') < $(menu).prop('scrollHeight')) {
            $('.menu-element').css('padding-left', '3px');
        } else {
            $('.menu-element').css('padding-left', '9px');
        }
    }
    changeMenu();
    $(window).on('resize', function () {
        changeMenu();
    });
});
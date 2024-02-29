$(window).on("load", function () {

    "use strict";

    $('.side-menu').removeClass('hidden');
    $('.link').addClass('d-none');

    setTimeout(function () {
        $(".loader").fadeOut("slow");
    }, 1000);
});

jQuery(function ($) {

    "use strict";

/* ===================================
       Header Appear
====================================== */

$(window).on('scroll', function () {

    if ($(this).scrollTop() > 200) { // Set position from top to add class
        $('.inner-header').addClass('header-appear');
        $('.link').removeClass('d-none');
    } else {
        $('.inner-header').removeClass('header-appear');
        $('.link').addClass('d-none');
    }
});

/*===================================
    Go Top Scroll
====================================== */

$(function(){
    // Scroll Event
    $(window).on('scroll', function(){
        var scrolled = $(window).scrollTop();
        if (scrolled > 600) $('.go-top').addClass('active');
        if (scrolled < 600) $('.go-top').removeClass('active');
    });
    // Click Event
    $('.go-top').on('click', function() {
        $("html, body").animate({ scrollTop: "0" },  500);
    });
});

/* ===================================
    Side Menu
====================================== */

if ($("#sidemenu_toggle").length) {
    $("#sidemenu_toggle").on("click", function () {
        $(".side-menu").removeClass("side-menu-opacity");
        $(".pushwrap").toggleClass("active");
        $(".side-menu").addClass("side-menu-active"), $("#close_side_menu").fadeIn(700)
    }), $("#close_side_menu").on("click", function () {
        $(".side-menu").removeClass("side-menu-active"), $(this).fadeOut(200), $(".pushwrap").removeClass("active");
        setTimeout(function(){
            $(".side-menu").addClass("side-menu-opacity");
        }, 500);
    }), $(".side-nav .navbar-nav .nav-link, .side-logo").on("click", function () {
        $(".side-menu").removeClass("side-menu-active"), $("#close_side_menu").fadeOut(200), $(".pushwrap").removeClass("active");
        setTimeout(function(){
            $(".side-menu").addClass("side-menu-opacity");
        }, 500);
    }), $("#btn_sideNavClose").on("click", function () {
        $(".side-menu").removeClass("side-menu-active"), $("#close_side_menu").fadeOut(200), $(".pushwrap").removeClass("active");
        setTimeout(function(){
            $(".side-menu").addClass("side-menu-opacity");
        }, 500);
    });
}

    /* ===================================
            WOW Animation
    ====================================== */

    if ($(window).width() > 991) {
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true
        });
        new WOW().init();
    }
});


/* ===================================
            CUSTOM DE GENERAL
====================================== */

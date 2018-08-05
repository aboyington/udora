$(document).ready(function ($) {
    "use strict";


    if ($(".tse-scrollable").length) {
        $(".tse-scrollable").TrackpadScrollEmulator();
    }

    if ($(".date-picker").length) {
        $(".date-picker").datepicker();
    }

    //heroSectionHeight();

    if (viewport.is('xs')) {
        $(".map-wrapper").height($(window).height() - $("#page-header").height());
        $(".has-background").css("min-height", $(window).height() - $("#page-header").height() + "px");
    } else {
        $(".hero-section.full-screen").height($(window).height() - $("#page-header").height() - 64);
    }


    // Render hero search form ---------------------------------------------------------------------------------------------


    var h = window.innerHeight;
    var w = window.innerWidth;

    if (w >= 768) {
        $(".search-form.vertical").css("top", ($(".hero-section").height() / 2) - ($(".search-form .wrapper").height() / 2));
        trackpadScroll("initialize");
    }



    //  Map in Row listing -------------------------------------------------------------------------------------------------

    $(".item.item-row").each(function () {
        var element = "map" + $(this).attr("data-id");
        var place;
        $(this).find(".map").attr("id", element);
        var _latitude = $(this).attr("data-latitude");
        var _longitude = $(this).attr("data-longitude");
        if ($(this).attr("data-address")) {
            place = $(this).attr("data-address");
        } else {
            place = false;
        }
        simpleMap(_latitude, _longitude, element, false, place);
    });

    //  Close "More" menu on click anywhere on page ------------------------------------------------------------------------

    $(document).on("click", function (e) {
        if (e.target.className == "controls-more") {
            $(".controls-more.show").removeClass("show");
            $(e.target).addClass("show");

        } else {
            $(".controls-more.show").each(function () {
                $(this).removeClass("show");
            });
        }
    });

    //  Duplicate desired element ------------------------------------------------------------------------------------------

    $(".duplicate").live("click", function (e) {
        e.preventDefault();
        var duplicateElement = $(this).attr("href");
        var parentElement = $(duplicateElement)[0].parentElement;
        $(parentElement).append($(duplicateElement)[0].outerHTML);
    });


    // Sidebar trigger
    $("#sidebar-trigger").click(function () {
        $(".results-wrapper").toggleClass("sidebar-hide");
        var check_icon = $("#trigger-icon").hasClass("ion-arrow-left-b");
        if (check_icon === true) {
            $("#trigger-icon").removeClass("ion-arrow-left-b").addClass("ion-arrow-right-b");
        } else {
            $("#trigger-icon").removeClass("ion-arrow-right-b").addClass("ion-arrow-left-b")
        }
    })

    $('.scroll-button').on('click', function () {
        $('body, html').animate({
            'scrollTop': $('.home-wrapper').outerHeight(true)
        });
        return false;
    });

    $('#search-start').click(function () {
        if ($(".searchform-toggle").length) {
            $(".search-form").slideToggle();
        }
    })

});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Functions
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function ratingPassive(element) {
    $(element).find(".rating-passive").each(function () {
        for (var i = 0; i < 5; i++) {
            if (i < $(this).attr("data-rating")) {
                $(this).find(".stars").append("<figure class='active ion-ios-star'></figure>")
            } else {
                $(this).find(".stars").append("<figure class='ion-ios-star'></figure>")
            }
        }
    });
}


function trackpadScroll(method) {
    if (method == "initialize") {
        if ($(".results-wrapper").find("form").length) {
            var _h = parseInt($('#mapplaces_search_results').height()) - parseInt($('.hero-section.has-map .results-wrapper .search-form').outerHeight());
            $('.results-ts-scr.results,.tse-scroll-content').height(_h);
            //$(".results-wrapper .results").height($(".results-wrapper").height() - $(".results-wrapper .form")[0].clientHeight);
        }
    } else if (method == "recalculate") {
        setTimeout(function () {
            if ($(".tse-scrollable").length) {
                $(".tse-scrollable").TrackpadScrollEmulator("recalculate");
            }
        }, 1000);
    }
}


// Viewport ------------------------------------------------------------------------------------------------------------

var viewport = (function () {
    var viewPorts = ['xs', 'sm', 'md', 'lg'];

    var viewPortSize = function () {
        return window.getComputedStyle(document.body, ':before').content.replace(/"/g, '');
    };

    var is = function (size) {
        if (viewPorts.indexOf(size) == -1) throw "no valid viewport name given";
        return viewPortSize() == size;
    };

    var isEqualOrGreaterThan = function (size) {
        if (viewPorts.indexOf(size) == -1) throw "no valid viewport name given";
        return viewPorts.indexOf(viewPortSize()) >= viewPorts.indexOf(size);
    };

    // Public API
    return {
        is: is,
        isEqualOrGreaterThan: isEqualOrGreaterThan
    }


})();

$('document').ready(function () {
    $('.dropdown-field .dropdown-field-toggle').click(function () {
        $(this).parent().toggleClass('f-open')
    })

    $(".searchform-toggle").click(function () {
        $(".search-form").slideToggle();
    });

    /* Page login/register*/
    $('.js-toggle-login-popup').on('click', function (e) {
        e.preventDefault();
        $('.navbar__gamburger__icon').removeClass('x');
        $('body').removeClass('is-mobile-navbar-open');
        if ($('body').hasClass('is-register-popup-open')) {
            $('body').removeClass('is-register-popup-open');
        };
        if (!$('body').hasClass('is-login-popup-open')) {
            $('body').addClass('is-login-popup-open');
            $('body').addClass('fixed-position');
        } else {
            $('body').removeClass('is-login-popup-open');
            $('body').removeClass('fixed-position');
        }
    })
    $('.js-toggle-register-popup').on('click', function (e) {
        e.preventDefault();
        $('.navbar__gamburger__icon').removeClass('x');
        $('body').removeClass('is-mobile-navbar-open');
        if ($('body').hasClass('is-login-popup-open')) {
            $('body').removeClass('is-login-popup-open');
        };
        if (!$('body').hasClass('is-register-popup-open')) {
            $('body').addClass('is-register-popup-open');
            $('body').addClass('fixed-position');
        } else {
            $('body').removeClass('is-register-popup-open');
            $('body').removeClass('fixed-position');
        }
    })

    $('.js-close-login-register-popups').on('click', function (e) {
        e.preventDefault();
        $('.navbar__gamburger__icon').removeClass('x');
        $('body').removeClass('is-login-popup-open');
        $('body').removeClass('is-register-popup-open');
        $('body').removeClass('fixed-position');
    })


    $('.js-toggle-mobile-navbar').on('click', function () {
        $('body').removeClass('is-register-popup-open');
        $('body').removeClass('is-login-popup-open');
        if (!$('body').hasClass('is-mobile-navbar-open')) {
            $('body').addClass('is-mobile-navbar-open');
            $('body').addClass('fixed-position');
            $('.navbar__gamburger__icon').addClass('x');
        } else {
            $('body').removeClass('is-mobile-navbar-open');
            $('.navbar__gamburger__icon').removeClass('x');
            $('body').removeClass('fixed-position');
        }
    });


    $('.js-close-mobile-navbar').on('click', function() {
        if ($('body').hasClass('is-mobile-navbar-open')) {
            $('body').removeClass('is-mobile-navbar-open');
            $('.navbar__gamburger__icon').removeClass('x');
            $('body').removeClass('fixed-position');
        }
    })

})
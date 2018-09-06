/*
    Name: UDora
    Description: Find your events

    TABLE OF CONTENTS:
    1. Sticky Header
    2. Blog bookmark
    3. Add to favourites
    4. Mobile menu
    5. Login
    6. My Info Page
    7. Map
*/

$(function () {

    

    var $image_gallery = $("#imageGallery");

    if ($image_gallery.length) {
        $('#imageGallery').lightSlider({
            gallery: true,
            item: 1,
            loop: true,
            slideMargin: 0,
            thumbItem: 9
        });
    }

    var $equal_height = $(".equal-height");

    if ($equal_height.length) {
        $('.equal-height').matchHeight();
    }



    $('#start-date, #end-date').datetimepicker();
    $('#start-time, #end-time').datetimepicker({
        format: 'LT'
    });




    /* 2. Blog bookmark */

    $(".blog-bookmark").click(function () {
        $(this).toggleClass("bookmarked");
    })

    /* 3. Add to favourites */

    $(".add-event-btn").click(function () {
        $(".not-added").toggle();
        $(".added").toggle();
    })

    /* 5. Login */

    $('.button-login').css('cursor', 'pointer');
    $("#profile-img").click(function () {
        $(".profile-box-wrapper").toggle();
    });
    $(".create-account").click(function () {
        $(".create-account-form").fadeIn();
    })
    $(".have-account").click(function () {
        $(".create-account-form").fadeOut();
    })
    $(".button-login").click(function () {
        $(".login-form-background").fadeOut(200);
        // $('body').removeClass("fixed-position");
        $(".login-menu").hide();
        $("#profile-img").show();
        $(".messages").show();
    })
    $("#profile-sign-out").click(function () {
        $(".login-menu").show();
        $("#profile-img").hide();
        $(".profile-box-wrapper").fadeOut();
        $(".messages").hide();
    })



    /* 6. My Info Page */


    // First and last name    
    $("#edit-info-button").click(function () {
        $(this).hide();
        $(".profile-statistics").hide();
        $("#save-info-button").show();
        $("#cancel-info-button").show();
        $("#change-name-form").show();
        $(".file_upload").show();
    });

    $("#save-info-button, #cancel-info-button").click(function () {
        $("#save-info-button").hide();
        $("#cancel-info-button").hide();
        $("#change-name-form").hide();
        $(".file_upload").hide();
        $("#edit-info-button").show();
        $(".profile-statistics").show();
    });


    //Email information
    $("#edit-email-button").click(function () {
        $(this).hide();
        $("#email-information").hide();
        $("#save-email-button").show();
        $("#cancel-email-button").show();
        $("#change-email-form").show();
    });

    $("#save-email-button, #cancel-email-button").click(function () {
        $("#save-email-button").hide();
        $("#cancel-email-button").hide();
        $("#change-email-form").hide();
        $("#edit-email-button").show();
        $("#email-information").show();
    });


    // Company information     
    $("#edit-info-company").click(function () {
        $(this).hide();
        $("#company-information").hide();
        $("#save-company-button").show();
        $("#cancel-company-button").show();
        $("#change-company-form").show();
    });

    $("#save-company-button, #cancel-company-button").click(function () {
        $("#save-company-button").hide();
        $("#cancel-company-button").hide();
        $("#change-company-form").hide();
        $("#edit-info-company").show();
        $("#company-information").show();
    });


    // Company information     
    $("#edit-contact-info").click(function () {
        $(this).hide();
        $("#contact-details").hide();
        $("#save-contact-info").show();
        $("#cancel-contact-info").show();
        $("#contact-details-form").show();
    });

    $("#save-contact-info, #cancel-contact-info").click(function () {
        $("#save-contact-info").hide();
        $("#cancel-contact-info").hide();
        $("#contact-details-form").hide();
        $("#edit-contact-info").show();
        $("#contact-details").show();
    });


    // Other information     
    $("#edit-other-information").click(function () {
        $(this).hide();
        $("#other-information").hide();
        $("#save-other-information").show();
        $("#cancel-other-information").show();
        $("#other-information-form").show();
    });

    $("#save-other-information, #cancel-other-information").click(function () {
        $("#save-other-information").hide();
        $("#cancel-other-information").hide();
        $("#other-information-form").hide();
        $("#edit-other-information").show();
        $("#other-information").show();
    });


    $(".dropbtn").click(function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show-content");
    });

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show-content')) {
                    openDropdown.classList.remove('show-content');
                }
            }
        }
    }


});
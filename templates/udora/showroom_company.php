<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
<!-- Custom HTML -->
<?php _widget('header_menu');?>
<!-- Carousel -->
<!-- Features Section Events -->
<div class="widget-content">
    <div id="contact-map" class="map" style=" height: 325px;"></div>
</div>
<div class="container marg50">
    <div class="row">
        <div class="col-lg-9 event-text border-right">
            <div class="marg20">
                    <h4>{page_title}</h4>
                    <hr>
                <div class="">
                         {page_body}
                    {has_page_documents}
                    <h5>{lang_Filerepository}</h5>
                    <ul>
                    {page_documents}
                    <li>
                        <a href="{url}">{filename}</a>
                    </li>
                    {/page_documents}
                    </ul>
                    {/has_page_documents}
                </div>
            </div>
            <?php _widget('center_imagegallery');?>
        </div>
        <div class="col-lg-3">
            <div class="promo-text-blog text-center"><?php echo lang_check('Overview');?></div>
            <div class="widget-box">
                <p class="bottom-border"><strong>
                {lang_Company}
                </strong> <span>{page_title}</span>
                <br style="clear: both;" />
                </p>
                <p class="bottom-border"><strong>
                {lang_Address}
                </strong> <span>{showroom_data_address}</span>
                <br style="clear: both;" />
                </p>
                <p class="bottom-border"><strong>
                {lang_Keywords}
                </strong> <span>{page_keywords}</span>
                <br style="clear: both;" />
                </p>
            </div>
            
            <div class="promo-text-blog center-align col-xs-12" id="form">{lang_Enquireform}</div>
            <!-- Contact form -->
            <form id='ajax-contact-form' class="sidebar-form col-xs-12" action="{page_current_url}#form" name='contact-form' method='POST'>
                {validation_errors} {form_sent_message}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_firstname}">
                            <label for="firstname">{lang_FirstLast}</label>
                           <input type="text" id="firstname" name='firstname' class="form form-control" value="{form_value_firstname}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_email}">
                            <label for="email">{lang_Email}</label>
                             <input type="text" name="email" id="email" class="form form-control" value="{form_value_email}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_phone}">
                            <label for="phone">{lang_Phone}</label>
                            <input type="text" name="phone" id="phone" class="form form-control" value="{form_value_phone}" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_address}">
                            <label for="address">{lang_Address}</label>
                            <input type="text" name="address" id="address" class="form form-control" value="{form_value_address}" >
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <div class="form-group {form_error_message}">
                            <label for="message">{lang_Message}</label>
                            <textarea id="message" name="message" class="form textarea form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <?php if(config_item( 'captcha_disabled')===FALSE): ?>
                        <div class="form-group {form_error_captcha}">
                            <div class="row-fluid clearfix">
                                <div class="col-lg-6" style="padding-top:2px;">
                                    <?php echo $captcha[ 'image']; ?>
                                </div>
                                <div class="col-lg-6">
                                    <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                    <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>   
                    <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                    <div class="col-xs-12 col-sm-12 col-lg-12" >
                        <label class="control-label captcha"></label>
                        <div class="controls">
                            <?php _recaptcha(true); ?>
                        </div>
                    </div>
                    <?php endif; ?>    
                </div>
                <button type="submit" id="valid-form" class="btn sidebar-button accent-button">{lang_Send}</button>
            </form>
        </div>
    </div>
</div>

<?php _widget('custom_footer');?>
<?php _widget('custom_javascript');?>


<?php
    if(!empty($showroom_data_gps)):;
?>
<script>
 
    $(document).ready(function(){
    var mapContact;
        
    if($('#contact-map').length){
        
    var myLocationEnabled = true;
    var scrollwheelEnabled = false;
    
    var markersContact = new Array();
    var mapOptions = {
        center: new google.maps.LatLng({showroom_data_gps}),
        zoom: {settings_zoom},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
        styles:style_map
    };
    
    var mapContact = new google.maps.Map(document.getElementById('contact-map'), mapOptions);


    marker = new google.maps.Marker({
        position: new google.maps.LatLng({showroom_data_gps}),
        map: mapContact,
        icon: 'assets/img/markers/marker-transparent.png'
    });

    markerOptions_1 = {
        content: "<div class='item infobox infobox2'>{showroom_data_address}<br />{lang_GPS}: {showroom_data_gps}</div>",
        disableAutoPan: false,
        maxWidth: 0,
        pixelOffset: new google.maps.Size(-135, -40),
        zIndex: null,
        infoBoxClearance: new google.maps.Size(1, 1),
        boxClass: "infobox-wrapper",
        enableEventPropagation: true,
        closeBoxMargin: "0px 0px -8px 0px",
        closeBoxURL: "assets/img/close-btn.png",
        alignBottom: true,
        position: new google.maps.LatLng({showroom_data_gps}),
        isHidden: false,
        pane: "floatPane",
    };
    marker.infobox = new InfoBox(markerOptions_1);
    marker.infobox.isOpen = false;
    //markersContact.push(marker);

    // marker
    var markerContent =
    '<div class="marker" data-id="<?php _che($item['gps']); ?>">' +
        '<div class="title"><?php echo str_replace("'", "\'", $page_title) ?></div>' +
        '<div class="marker-wrapper">' +
            '<div class="pin">' +
                '<div class="image" style="background-image: url(<?php echo _che($website_favicon_url); ?>);"></div>' +
            '</div>' +
        '</div>' +
    '</div>';

    markerOptions_2 = {
        draggable: false,
                content: markerContent,
                disableAutoPan: true,
                pixelOffset: new google.maps.Size(-21, -58),
                position: new google.maps.LatLng({showroom_data_gps}),
                closeBoxMargin: "",
                closeBoxURL: "",
                flat: true,
                isHidden: false,
                //pane: "mapPane",
                enableEventPropagation: true
    };
    marker.marker = new InfoBox(markerOptions_2);      
    marker.marker.isHidden = false;      
    marker.marker.open(mapContact, marker);
    markersContact.push(marker);

    // action        
    google.maps.event.addListener(marker, "click", function (e) {
        var curMarker = this;

        $.each(markersContact, function (index, marker) {
            // if marker is not the clicked marker, close the marker
            if (marker !== curMarker) {
                marker.infobox.close();
                marker.infobox.isOpen = false;
            }
        });

        if(curMarker.infobox.isOpen === false) {
            curMarker.infobox.open(mapContact, this);
            curMarker.infobox.isOpen = true;
            mapContact.panTo(curMarker.getPosition());


            setTimeout(function(){
                $('.infobox-wrapper').addClass("show");
            }, 10);

        } else {
            curMarker.infobox.close();
            curMarker.infobox.isOpen = false;
        }
    });

    google.maps.event.addListener(marker.infobox,'closeclick',function(){
        $('.marker').removeClass("active");
    });

    $(".marker").live("click",function(){
        $('.marker').removeClass("active");
        $(this).addClass("active");
    });
    }
});
</script>
<?php endif;?>   
</body>
</html>

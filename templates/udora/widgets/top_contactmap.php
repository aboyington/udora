<?php
/*
Widget-title: Contact map
Widget-preview-image: /assets/img/widgets_preview/top_contactmap.jpg
*/
?>

<div class="widget-content">
    <div id="contact-map" class="map" style=" height: 375px;"></div>
</div>

<?php
    if(!empty($settings_gps)):;
?>
<script>
 
    $(document).ready(function(){
    var mapContact;
        
    if($('#contact-map').length){
        
    var myLocationEnabled = true;
    var scrollwheelEnabled = false;
    
    var markersContact = new Array();
    var mapOptions = {
        center: new google.maps.LatLng({settings_gps}),
        zoom: {settings_zoom},
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: scrollwheelEnabled,
        styles:style_map
    };
    
    var mapContact = new google.maps.Map(document.getElementById('contact-map'), mapOptions);


    marker = new google.maps.Marker({
        position: new google.maps.LatLng({settings_gps}),
        map: mapContact,
        icon: 'assets/img/markers/marker-transparent.png'
    });

    markerOptions_1 = {
        content: "<div class='item infobox infobox2'>{settings_websitetitle}<br />{lang_Address}: {settings_gps}</div>",
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
        position: new google.maps.LatLng({settings_gps}),
        isHidden: false,
        pane: "floatPane",
    };
    marker.infobox = new InfoBox(markerOptions_1);
    marker.infobox.isOpen = false;
    //markersContact.push(marker);

    // marker
    var markerContent =
    '<div class="marker" data-id="<?php _che($item['gps']); ?>">' +
        '<div class="title"><?php echo str_replace("'", "\'", $settings_websitetitle) ?></div>' +
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
                position: new google.maps.LatLng({settings_gps}),
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
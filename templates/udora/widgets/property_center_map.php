<div class="marg20">
    <h4><?php echo lang_check('Location');?></h4>
    <hr>
    <?php if(!empty($estate_data_gps)): ?>
    <div class="places_select" style="display: none;">
        <a class="btn btn-link" type="button" rel="hospital,health"><img src="assets/img/places_icons/hospital.png" alt='hospital,health'/><span class="hidden-xs"> {lang_Health}</span></a>
<!--         <a class="btn btn-link" type="button" rel="park"><img src="assets/img/places_icons/park.png" alt='park' /><span class="hidden-xs"> {lang_Park}</span></a> -->
        <a class="btn btn-link" type="button" rel="atm,bank"><img src="assets/img/places_icons/atm.png" alt='atm'/><span class="hidden-xs"> {lang_ATMBank}</span></a>
        <a class="btn btn-link" type="button" rel="gas_station"><img src="assets/img/places_icons/petrol.png" alt="gas_station"/><span class="hidden-xs"> {lang_PetrolPump}</span></a>
        <a class="btn btn-link" type="button" rel="food,bar,cafe,restourant"><img src="assets/img/places_icons/restourant.png" alt="food" /><span class="hidden-xs"> {lang_Restaurant}</span></a>
        <a class="btn btn-link" type="button" rel="store"><img src="assets/img/places_icons/store.png" alt="store"/><span class="hidden-xs"> {lang_Store}</span></a>
    </div>
    <div class="property-map" id='property-map' style='height: 405px;'></div>
    <?php else: ?>
        <p class="alert alert-success"><?php _l('Not available'); ?></p>
    <?php endif;?>
</div>
<?php if(!empty($estate_data_gps)): ?>
<script>
(function(){
     
var IMG_FOLDER = "assets/js/dpejes";
var map;
$(document).ready(function(){
        
    // map init    
    if($('#property-map').length){
        var myLocationEnabled = true;
        var style_map = '';
        var scrollwheelEnabled = false;

        var markers1 = new Array();
        var mapOptions1 = {
            center: new google.maps.LatLng({estate_data_gps}),
            zoom: {settings_zoom}+6,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            styles:style_map
        };

        map = new google.maps.Map(document.getElementById('property-map'), mapOptions1);
        map_propertyLoc = map  

        var marker1 = new google.maps.Marker({
            position: new google.maps.LatLng({estate_data_gps}),
            map: map,
           // icon: 'assets/img/markers/house.png'
        });

        var myOptions2 = {
            content: "<div class='infobox2'>{estate_data_address}<br />{lang_GPS}: {estate_data_gps}</div>",
            disableAutoPan: false,
            maxWidth: 0,
            pixelOffset: new google.maps.Size(-138, -90),
            zIndex: null,
            closeBoxURL: "",
            infoBoxClearance: new google.maps.Size(1, 1),
            position: new google.maps.LatLng(<?php _che($item['gps']); ?>),
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: false
        };

        marker1.infobox = new InfoBox(myOptions2);
        marker1.infobox.isOpen = false;
        markers1.push(marker1);
        
        // action        
        google.maps.event.addListener(marker1, "click", function (e) {
            var curMarker = this;

            $.each(markers1, function (index, marker) {
                // if marker is not the clicked marker, close the marker
                if (marker !== curMarker) {
                    marker.infobox.close();
                    marker.infobox.isOpen = false;
                }
            });

            if(curMarker.infobox.isOpen === false) {
                curMarker.infobox.open(map, this);
                curMarker.infobox.isOpen = true;
                map.panTo(curMarker.getPosition());
            } else {
                curMarker.infobox.close();
                curMarker.infobox.isOpen = false;
            }

        }); 

        if(myLocationEnabled){
            var controlDiv = document.createElement('div');
            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
            HomeControl(controlDiv, map)
        }

    } 
     
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>       
    // init_gmap_searchbox();
    if (typeof init_directions == 'function')
     {
         $(".places_select a").click(function(){
             init_places($(this).attr('rel'), $(this).find('img').attr('src'));
         });
         
         var selected_place_type = 4;

         init_directions();
         directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});


         directionsDisplay.setMap(map);
         init_places($(".places_select a:eq("+selected_place_type+")").attr('rel'), $(".places_select a:eq("+selected_place_type+") img").attr('src'));

     }
    <?php endif;?>
}); 

<?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>  
var map_propertyLoc;
var markers = [];
var generic_icon;

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var placesService;

function init_places(places_types, icon) {
    var pyrmont = new google.maps.LatLng({estate_data_gps});

    setAllMap(null);

    generic_icon = icon;


    var places_type_array = places_types.split(','); 

    var request = {
        location: pyrmont,
        radius: 2000,
        types: places_type_array
    };

    infowindow = new google.maps.InfoWindow();
    placesService = new google.maps.places.PlacesService(map);
    placesService.nearbySearch(request, callback);

}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

function calcRoute(source_place, dest_place) {
  var selectedMode = 'WALKING';
  var request = {
      origin: source_place,
      destination: dest_place,
      // Note that Javascript allows us to access the constant
      // using square brackets and a string value as its
      // "property."
      travelMode: google.maps.TravelMode[selectedMode]
  };

  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      //console.log(response.routes[0].legs[0].distance.value);
    }
  });
}

function createMarker(place) {
  var placeLoc = place.geometry.location;
  var propertyLocation = new google.maps.LatLng({estate_data_gps});

    if(place.icon.indexOf("generic") > -1)
    {
        place.icon = generic_icon;
    }

    var image = {
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(25, 25)
    };

  var marker = new google.maps.Marker({
    map: map,
    icon: image,
    position: place.geometry.location
  });

  markers.push(marker);

  var distanceKm = (calcDistance(propertyLocation, placeLoc)*1.2).toFixed(2);
  var walkingTime = parseInt((distanceKm/5)*60+0.5);

  google.maps.event.addListener(marker, 'click', function() {

        //drawing route
        calcRoute(propertyLocation, placeLoc);

    // Fetch place details
    placesService.getDetails({ placeId: place.place_id }, function(placeDetails, statusDetails){



        //open popup infowindow
        infowindow.setContent(place.name+'<br />{lang_Distance}: '+distanceKm+'{lang_Km}'+
                              '<br />{lang_WalkingTime}: '+walkingTime+'{lang_Min}'+
                              '<br /><a target="_blank" href="'+placeDetails.url+'">{lang_Details}</a>');
        infowindow.open(map_propertyLoc, marker);
    });

  });
}

//calculates distance between two points
function calcDistance(p1, p2){
  return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
}
<?php endif;?>
    
 })()  
       
</script>
<?php endif;?>
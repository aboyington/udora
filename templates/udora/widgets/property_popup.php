<div class="row property-content">
    <div class="col-lg-9 event-text border-right">
        <div class="row">
            <ul id="imageGallery">
                <?php if(count($slideshow_property_images)>0):?>
                    <?php foreach($slideshow_property_images as $file): ?>
                        <li data-thumb="<?php echo _simg($file['url'], '850x500');?>" data-src="<?php echo $file['url'];?>">
                            <img src="<?php echo _simg($file['url'], '850x500');?>" class="img-responsive" />
                        </li>
                    <?php endforeach; ?>
                <?php endif;?>
            </ul>
        </div>
       <div class="row">
            <div class="cl-blog-text">
                <h3><?php _che($option_10);?></h3>
                
                <?php if(isset($option_81) && !empty($option_81)):?>

                <div class="description__item">
                    <div class="description__item__icon">
                    <i class="ion-android-time"></i>
                    </div>
                    <h5>
                    <?php
                    $_strtotime = strtotime($option_81);
                    $day = date('l',$_strtotime);
                    $day = strtolower($day);
                    $month = date('M',$_strtotime);
                    $month = strtolower($month);
                    ?>
                    <?php echo lang_check('cal_'.$day);?>, <?php echo lang_check('cal_'.$month);?> <?php echo date('d, g:i a', $_strtotime);?>
                    </h5>
                </div>
                <?php endif;?>
                <div class="description__item">
                    <div class="description__item__icon">
                        <i class="ion-ios-location"></i>
                    </div>
                    <h5><?php echo _ch($address);?></h5>
                </div>                
                
                <p><?php _che($estate_data_option_17, '<p class="alert alert-success">'.lang_check('Not available').'</p>'); ?></p>
            </div>
        </div>
        
        <!-- Accordeon -->
        <div class="row">
        <div class="marg20">
            <div class="ac-container">
                <div>
                    <input id="ac-4" name="accordion-2" type="radio" checked/>
                    <label for="ac-4"><?php echo lang_check('LOCATION');?></label>
                    <article class="ac-small">
                        <p><?php _che($address);?></p>
                    </article>
                </div>
                <div>
                    <input id="ac-6" name="accordion-2" type="radio" />
                    <label for="ac-6"><?php _che($options_name_21);?></label>
                    <article class="ac-small">
                        <ul class="widget-content amenities clearfix">
                            <?php if(isset($category_options_21))foreach($category_options_21 as $val): ?>
                                <?php if($val['is_checkbox']):?>
                                <li>
                                    <i class="<?php if(isset($val['option_value'])):?>fa fa-check<?php else:?> unchecked<?php endif;?>"></i><?php echo $val['option_name'];?><?php echo $val['icon'];?>
                                </li>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                </div>
                <div>
                    <input id="ac-7" name="accordion-2" type="radio" />
                    <label for="ac-7"><?php _che($options_name_52);?></label>
                    <article class="ac-small">
                        <ul class="widget-content amenities clearfix">
                            <?php if(isset($category_options_52))foreach($category_options_52 as $val): ?>
                                <?php if($val['is_checkbox']):?>
                                <li>
                                    <i class="<?php if(isset($val['option_value'])):?>fa fa-check<?php else:?> unchecked<?php endif;?>"></i><?php echo $val['option_name'];?><?php echo $val['icon'];?>
                                </li>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                </div>
                <div>
                    <input id="ac-8" name="accordion-2" type="radio" />
                    <label for="ac-8"><?php _che($options_name_43);?></label>
                    <article class="ac-small">
                        <ul class="widget-content amenities clearfix">
                            <?php if(isset($category_options_43))foreach($category_options_43 as $val): ?>
                                <?php if($val['is_text']):?>
                                <li>
                                   <?php echo $val['icon'];?> <?php echo $val['option_name'];?>:&nbsp;&nbsp; <?php _che(${"options_prefix_".$val['option_id']});?><?php _che($val['option_value']);?><?php _che(${"options_suffix_".$val['option_id']});?>
                                </li>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                </div>
            </div>
        </div>
    </div>
       
     <div class="marg20">
    <h4><?php echo lang_check('Location');?></h4>
    <hr>
    <?php if(!empty($gps)): ?>
    <div class="places_select" style="display: none;">
        <a class="btn btn-large" type="button" rel="hospital,health"><img src="<?php echo $assets_url;?>/img/places_icons/hospital.png" alt='hospital,health'/> {lang_Health}</a>
<!--         <a class="btn btn-large" type="button" rel="park"><img src="<?php //echo $assets_url;?>/img/places_icons/park.png" alt='park' /> {lang_Park}</a> -->
        <a class="btn btn-large" type="button" rel="atm,bank"><img src="<?php echo $assets_url;?>/img/places_icons/atm.png" alt='atm'/> {lang_ATMBank}</a>
        <a class="btn btn-large" type="button" rel="gas_station"><img src="<?php echo $assets_url;?>/img/places_icons/petrol.png" alt="gas_station"/> {lang_PetrolPump}</a>
        <a class="btn btn-large" type="button" rel="food,bar,cafe,restourant"><img src="<?php echo $assets_url;?>/img/places_icons/restourant.png" alt="food" /> {lang_Restourant}</a>
        <a class="btn btn-large" type="button" rel="store"><img src="<?php echo $assets_url;?>/img/places_icons/store.png" alt="store"/> {lang_Store}</a>
    </div>
    <div class="property-map" id='property-map' style='height: 405px;'></div>
    <?php else: ?>
        <p class="alert alert-success"><?php _l('Not available'); ?></p>
    <?php endif;?>
</div>
<?php if(!empty($gps)): ?>
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
            center: new google.maps.LatLng(<?php _che($gps);?>),
            zoom: <?php echo $settings_zoom;?>+6,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            styles:style_map
        };

        map = new google.maps.Map(document.getElementById('property-map'), mapOptions1);
        map_propertyLoc = map  

        var marker1 = new google.maps.Marker({
            position: new google.maps.LatLng(<?php _che($gps);?>),
            map: map,
           // icon: 'assets/img/markers/house.png'
        });

        var myOptions2 = {
            content: "<div class='infobox2'><?php echo $estate_data_address;?> <br /><?php echo lang_check('GPS');?>: <?php _che($gps);?></div>",
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
    var pyrmont = new google.maps.LatLng(<?php _che($gps);?>);

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
  var propertyLocation = new google.maps.LatLng(<?php _che($gps);?>);

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
        
        
    <div class="marg20">
        <h4><?php echo lang_check('Disqus comments');?></h4>
        <hr>
        <div class="">
            <div id="disqus_thread"></div>
            <script>

            /**
            *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
            *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

            var disqus_config = function () {
            this.page.url = '<?php echo $page_current_url; ?>';  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = "<?php echo $property_id; ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };

            (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://http-udora-io.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
            })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
    </div>

    </div>
    <div class="col-lg-3">
        <img style="max-width: 100%;" class="col-xs-12 col-sm-6 col-lg-12 img-responsive qr-code" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo site_url('property/'.$property_id.'/'.$lang_code);?>&choe=UTF-8" alt="qr code"/>
        
        <!-- Social section -->
        <div class="promo-text-blog center-align col-xs-12 col-sm-6 col-lg-12"><?php echo lang_check('Tell your friends!');?></div>
        <div class="raw">
            <div class="text-center col-xs-12 col-sm-6 col-lg-12 blog-sidebar-share">
                <a href="https://www.facebook.com/share.php?u=<?php echo site_url('property/'.$property_id.'/'.$lang_code);?>&title=<?php _che($option_10);?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btn btn-social-icon btn-facebook"><i class="ion-social-facebook"></i></a>
                <a href="https://plus.google.com/share?url=<?php echo site_url('property/'.$property_id.'/'.$lang_code);?>" class="btn btn-social-icon btn-google" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="ion-social-googleplus-outline"></i></a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo site_url('property/'.$property_id.'/'.$lang_code);?>&via=<?php _che($settings_websitetitle);?>&related=<?php _che($option_10);?>" class="btn btn-social-icon btn-twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="ion-social-twitter"></i></a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo site_url('property/'.$property_id.'/'.$lang_code);?>&via=<?php _che($settings_websitetitle);?>&related=<?php _che($option_10);?>" class="btn btn-social-icon btn-instagram" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="ion-social-instagram-outline"></i></a>
            </div>
        </div>   
        <?php if(file_exists(APPPATH.'controllers/admin/favorites.php')):?>
        <?php
           $favorite_added = false;
           if(count($not_logged) == 0)
           {
               $CI =& get_instance();
               $CI->load->model('favorites_m');
               $CI->load->library('session');
               $favorite_added = $CI->favorites_m->check_if_exists($CI->session->userdata('id'), 
                                                                   $property_id);
               if($favorite_added>0)$favorite_added = true;
           }
        ?>

        <a type="button"  class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12 / js-add-to-favorites" href="javascript:;" style="<?php echo ($favorite_added)?'display:none;':''; ?>; position: fixed; bottom: 10vh; right: 5vw; z-index: 999;">
            <i class="ion-ios-star-outline favourite"></i><?php echo lang_check('Add to favorites'); ?><i class="load-indicator"></i>
        </a>

        <a type="button" class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12 / js-remove-from-favorites" href="javascript:;" style="<?php echo (!$favorite_added)?'display:none;':''; ?>">
            <i class="ion-ios-star-outline favourite"></i><?php echo lang_check('Remove from favorites'); ?><i class="load-indicator"></i>
        </a>

        <script type="text/javascript">
        $(document).ready(function() {
            // [START] Add to favorites //  

            $(".js-add-to-favorites").click(function(e){
                e.preventDefault();
                var data = { property_id: "<?php _che($property_id);?>" };
                var load_indicator = $(this).find('.load-indicator');
                load_indicator.css('display', 'inline-block');
                $.post("<?php echo $api_private_url;?>/add_to_favorites/<?php _che($lang_code);?>", data, 
                       function(data){

                    ShowStatus.show(data.message);

                    load_indicator.css('display', 'none');

                    if(data.success)
                    {
                        $(".js-add-to-favorites").css('display', 'none');
                        $(".js-remove-from-favorites").css('display', 'inline-block');
                    }
                });

                return false;
            });

            $(".js-remove-from-favorites").click(function(e){
                e.preventDefault()
                var data = { property_id: "<?php _che($property_id);?>" };

                var load_indicator = $(this).find('.load-indicator');
                load_indicator.css('display', 'inline-block');
                $.post("<?php echo $api_private_url;?>/remove_from_favorites/<?php _che($lang_code);?>", data, 
                       function(data){

                    ShowStatus.show(data.message);

                    load_indicator.css('display', 'none');

                    if(data.success)
                    {
                        $(".js-remove-from-favorites").css('display', 'none');
                        $(".js-add-to-favorites").css('display', 'inline-block');
                    }
                });

                return false;
            });
            // [END] Add to favorites //  
        });
        </script>
        <?php endif; ?>
        <?php if(file_exists(APPPATH.'libraries/Pdf.php')) : ?>
            <a href="<?php echo site_url('api/pdf_export/'.$property_id.'/'.$lang_code) ;?>" class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12" style="margin-top:30px;"><?php _l('PDF export');?></a>
        <?php endif;?>

        <?php if(count($agent)):?>
        <div class="promo-text-blog center-align col-xs-12"><?php echo lang_check('Organizer');?></div>
        <div class="profile-settings profile-settings-widget">
            <div class="col-sm-12 profile-wrapper">
                <div class="col-sm-12">
                    <img src="<?php _che($agent_image_url);?>" alt="" class="profile-img">
                </div>
                <div class="col-sm-12">
                    <div class="profile-statistics">
                        <h4 id="member-name" class="member-name"><a href="<?php _che($agent_url);?>"><?php  _che($agent_name_surname);?></a></h4>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?> 

        <?php //_widget('property_right_favorites');?>
        <?php //_widget('property_right_share');?>
        <?php //_widget('property_right_pdf');?>
        <?php //_widget('property_right_enquiry-form');?>
        <?php //_widget('property_right_agent-details');?>
    </div>
</div>
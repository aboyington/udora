<!-- Map -->
<div class="hero-section full-screen has-map has-sidebar" id="mapplaces_search_results">
    <div class="sw-tab map-wrapper mob-hidden">
        <div class="map" id="main-map"></div>
        <?php _widget('custom_float_menu');?>
    </div>
    <!--end map-wrapper-->
    <div class="sw-tab results-wrapper">
        <button class="sidebar-trigger" id="sidebar-trigger"><i class="ion-arrow-left-b" id="trigger-icon"></i></button>
        <div class="form search-form inputs-underline">
            <form class="flabel-anim">
                <input id="rectangle_ne" type="text" class="hidden" />
                <input id="rectangle_sw" type="text" class="hidden" />
                <?php if(config_item('tree_field_enabled') === TRUE):?>
                <script language="javascript">
                    /* [START] TreeField */
                    $(function() {
                        $(".search-form .TREE-GENERATOR select").change(function(){
                            var s_value = $(this).val();
                            var s_name_splited = $(this).attr('name').split("_"); 
                            var s_level = parseInt(s_name_splited[3]);
                            var s_lang_id = s_name_splited[1];
                            var s_field_id = s_name_splited[0].substr(6);

                            load_by_field($(this));

                            // Reset child selection and value generator
                            var generated_val = '';
                            $(this).parent().parent()
                            .find('select').each(function(index){
                                // console.log($(this).attr('name'));
                                if(index > s_level)
                                {
                                    $(this).find("option:gt(0)").remove();
                                    $(this).val('');
                                    $(this).selectpicker('refresh');
                                }
                                else
                                    generated_val+=$(this).find("option:selected").text()+" - ";
                            });
                            $("#sinputOption_"+s_lang_id+"_"+s_field_id).val(generated_val);
                            if($('.field-tree select').first().val() !=='')
                                $(".dropdown-field .value").html(generated_val);
                            else {
                                $(".dropdown-field .value").html('<?php echo lang_check('Location');?>');
                            }
                        });
                    });

                    function load_by_field(field_element, autoselect_next, s_values_splited)
                    {
                        if (typeof autoselect_next === 'undefined') autoselect_next = false;
                        if (typeof s_values_splited === 'undefined') s_values_splited = [];

                        var s_value = field_element.val();
                        var s_name_splited = field_element.attr('name').split("_"); 
                        var s_level = parseInt(s_name_splited[3]);
                        var s_lang_id = s_name_splited[1];
                        var s_field_id = s_name_splited[0].substr(6);
                        // console.log(s_value); console.log(s_level); console.log(s_field_id);

                        // Load values for next select
                        var ajax_indicator = field_element.parent().parent().parent().find('.ajax_loading');
                        var select_element = $("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
                        if(select_element.length > 0 && s_value != '')
                        {
                            ajax_indicator.css('display', 'block');
                            $.getJSON( "<?php echo site_url('api/get_level_values_select'); ?>/"+s_lang_id+"/"+s_field_id+"/"+s_value+"/"+parseInt(s_level+1), function( data ) {
                                //console.log(data.generate_select);
                                //console.log("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
                                ajax_indicator.css('display', 'none');

                                select_element.html(data.generate_select);
                                select_element.selectpicker('refresh');

                                if(autoselect_next)
                                {
                                    if(s_values_splited[s_level+1] != '')
                                    {
                                        select_element.find('option').filter(function () { return $(this).html() == s_values_splited[s_level+1]; }).attr('selected', 'selected');
                                        load_by_field(select_element, true, s_values_splited);
                                    }
                                }
                            });
                        }
                    }
                    /* [END] TreeField */
                </script>
                <?php endif; ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="search_option_smart" value="{search_query}" id="search_option_smart" placeholder="<?php echo lang_check('Keyword search');?>">
                    <label><?php echo lang_check('Keyword search');?></label>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group search_option_location-box">
                            <input type="text" class="form-control" name="search_option_location" value="{search_option_location}" id="search_option_location" placeholder="<?php echo lang_check('City, Country');?>">
                            <label><?php echo lang_check('City, Country');?></label>
                        </div>

                        <script>
                        // Create the autocomplete object, restricting the search to geographical
                        // location types.
                        var placeSearch, autocomplete;
                            var componentForm = {
                              street_number: 'short_name',
                              route: 'long_name',
                              locality: 'long_name',
                              administrative_area_level_1: 'short_name',
                              country: 'long_name',
                              postal_code: 'short_name'
                            };
                        var populate = {
                              street_number: '',
                              route: '',
                              locality: '',
                              administrative_area_level_1: '',
                              country: '',
                              postal_code: ''
                            };
                        autocomplete = new google.maps.places.Autocomplete(
                            (document.getElementById('search_option_location')),
                            {types: ['geocode']}
                            );

                        // fields in the form.
                        autocomplete.addListener('place_changed', function(){
                             var place = autocomplete.getPlace();

                             /*console.log(place)*/
                            for (var i = 0; i < place.address_components.length; i++) {
                                var addressType = place.address_components[i].types[0];
                                if (componentForm[addressType]) {
                                  var val = place.address_components[i][componentForm[addressType]];
                                  populate[addressType] = val
                                }
                            }      
                            $('#search_option_location')
                                    .attr('data-locality', populate.locality)
                                    .attr('data-admin_area', populate.administrative_area_level_1)
                                    .attr('data-country', populate.country)
                        });

                    </script>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                                <select id="search_radius" name="search_radius" class="form-control selectpicker">
                        <?php
                            $sel_values = array(0,50,100,200,500);
                            $suffix = lang_check('km');
                            $curr_value=NULL;

                            if(isset($_GET['search']))$search_json = json_decode($_GET['search']);
                            if(isset($search_json->v_search_radius))
                            {
                                $curr_value=$search_json->v_search_radius;
                            } else {
                                $curr_value = 50;
                            }

                            foreach($sel_values as $key=>$val)
                            {
                                if($curr_value == $val)
                                {
                                    echo "<option value=\"$val\" selected>$val$suffix</option>\r\n";
                                }
                                else
                                {
                                    echo "<option value=\"$val\">$val$suffix</option>\r\n";
                                }
                            }
                        ?>
                                </select>
                        </div><!-- /.form-group -->
                    </div>
                </div>

                
                <!--end form-group-->
                <div class="row">
                    <!-- <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                        <div class="dropdown dropdown-field d2">
                            <a href="#" class="dropdown-field-toggle">
                                <span class="value"><?php echo lang_check('Location');?> </span> <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="">
                                    <?php if(config_item('tree_field_enabled') === TRUE):?>
                                    <?php

                                        $CI =& get_instance();
                                        $CI->load->model('treefield_m');
                                        $field_id = 64;
                                        $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                                        $drop_selected = array();
                                        echo '<div class="tree TREE-GENERATOR">';
                                        echo '<div class="field-tree">';
                                        echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                                        echo '</div>';

                                        $levels_num = $CI->treefield_m->get_max_level($field_id);

                                        if($levels_num>0)
                                        for($ti=1;$ti<=$levels_num;$ti++)
                                        {
                                            $lang_empty = lang('treefield_'.$field_id.'_'.$ti);
                                            if(empty($lang_empty))
                                                $lang_empty = lang_check('Please select parent');

                                            echo '<div class="field-tree">';
                                            echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_'.$ti, array(''=>$lang_empty), array(), 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_'.$ti.'"');
                                            echo '</div>';
                                        }
                                        echo '</div>';

                                    ?>
                                    <script language="javascript">
                                        $(window).load(function()  {
                                            var load_val = '<?php echo search_value($field_id); ?>';
                                            var s_values_splited = (load_val+" ").split(" - "); 

                                            if(s_values_splited[0] != '')
                                            {
                                                var first_select = $('.TREE-GENERATOR').find('select:first');
                                                var id = first_select.find('option').filter(function () { return $(this).html() ==  s_values_splited[0]; }).attr('selected', 'selected').val();

                                                /* test fix */
                                                first_select.val(id)
                                                first_select.selectpicker('refresh')
                                                /* end test fix */

                                                //first_select.selectpicker('val', id);
                                                load_by_field(first_select, true, s_values_splited);
                                                first_load = false;
                                            }

                                        });

                                    </script>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div> -->
                    <!--end col-md-6-->
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                        <div class="dropdown dropdown-field d2">
                            <div class="">
                                <?php if(config_item('tree_field_enabled') === TRUE):?>
                                <?php

                                    $CI =& get_instance();
                                    $CI->load->model('treefield_m');
                                    $field_id = 79;
                                    $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                                    $drop_selected = array();
                                    $drop_options[''] = lang_check('Category');
                                    echo '<div class="tree TREE-GENERATOR">';
                                    echo '<div class="field-tree">';
                                    echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                                    echo '</div>';

                                    echo '</div>';

                                ?>
                                <script language="javascript">
                                    $(window).load(function()  {
                                        var load_val = '<?php echo (search_value($field_id)); ?>';
                                        var s_values_splited = (load_val+" ").split(" - "); 

                                        if(s_values_splited[0] != '')
                                        {
                                            var first_select = $('.TREE-GENERATOR').find('select:first');
                                            var id = first_select.find('option').filter(function () { return $(this).html().replace("&amp;", "&") ==  s_values_splited[0]; }).attr('selected', 'selected').val();
                                           
                                            /* test fix */
                                            first_select.val(id)
                                            first_select.selectpicker('refresh')
                                            /* end test fix */

                                            //first_select.selectpicker('val', id);
                                            load_by_field(first_select, true, s_values_splited);
                                            first_load = false;
                                        }

                                    });

                                </script>
                                <?php endif; ?>
                            </div>
                        </div>
                        <label><?php echo lang_check('Category');?></label>
                        </div>
                        <!--end form-group-->
                    </div>
                    <div class="col-sm-6 hidden">
                        <div class="form-group">
                            <select class="form-control selectpicker" name="search_option_2" id="search_option_2">
                                {options_values_2}
                            </select>
                        </div>
                        <!--end form-group-->
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="text" class="text-left" id="search_option_81_82" name="daterange" value="" placeholder="<?php echo lang_check('Date');?>" readonly="true"/>
                            <label><?php echo lang_check('Date');?></label>
                        </div>
                        <!--end form-group-->
                    </div>
                </div>
                <!--end row-->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right" id="search-start"><i class="ion-ios-search"></i></button>
                </div>
                <!--end form-group-->
            </form>
            <script>
            $(function () {
                $('input#search_option_81_82').daterangepicker({
                    "ranges": {
                        'Today': [moment(), moment()],
                        'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
                        'This Month': [moment().add('month'), moment().endOf('month')],
                        'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
                    },
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'MM-DD-YYYY HH:mm:ss'
                    },
                    "startDate": "<?php echo (search_value('81_from')) ? date('m/d/Y', strtotime(search_value('81_from'))) : date('m/d/Y',strtotime('first day of this month'));?>",
                    "endDate": "<?php echo (search_value('82_to')) ? date('m/d/Y', strtotime(search_value('82_to'))) : date('m/d/Y',strtotime('last day of this month'));?>",
                    "linkedCalendars": false,
                    "showCustomRangeLabel": false,
                    "alwaysShowCalendars": true,
                    "opens": "right",
                    "drops": "down"
                }, function (start, end, label) {
                    //console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
                });
                $('input#search_option_81_82').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });
                <?php if(!search_value('81_from') && !search_value('82_to')):?>
                    $('input#search_option_81_82').val("");
                <?php endif;?>
            });
            </script>
            <!--end form-hero-->

        </div>
        <div class="results results-ts-scr">
            <div class="tse-scrollable">
                <div class="tse-content">
                    <div class="section-title">
                        <h2><?php echo lang_check('Search Results');?><span class="results-number"><?php echo $total_rows; ?></span></h2>
                    </div>
                    <!--end section-title-->
                    <div class="results-content">
                        
                        {has_no_results}
                        <div class="result-answer">
                            <div class="alert alert-success">
                                {lang_Noestates}
                            </div>
                        </div>
                        <script>
                            $(function(){
                                $('.popup_request_to_event').removeClass('hidden');
                                $('.custom_noevents_form').removeClass('hidden');
                            })
                        </script>
                        {/has_no_results}
                        
                        <?php foreach($results as $key=>$item): ?>
                            <?php
                            $marker_id ='';
                            if(!empty($item['gps'])) {
                                $gps = explode(', ', $item['gps']);
                                $lat = floatval($gps[0]);
                                $lng = floatval($gps[1]);
                                $marker_id = $lat.$lng;
                            }
                            ?>

                            <div class="result-item" data-property_id="<?php echo _ch($item['id']); ?>" data-id="<?php echo $marker_id; ?>" href="<?php echo _ch($item['url']); ?>">
                                <a href="<?php echo _ch($item['url']); ?>" class="result-item-pop" data-property_id="<?php echo _ch($item['id']); ?>">
                                    <div class="result-item-detail">
                                        <div class="image" style="background-image: url(<?php echo _simg($item['thumbnail_url'], '100x115', true); ?>)">
                                            <figure><?php echo _ch($item['option_79']); ?></figure>
                                        </div>
                                        <div class="description">
                                            <h3 title="<?php echo _ch($item['option_10']); ?>"><?php echo _ch($item['option_10']); ?></h3>

                                            <?php if(isset($item['option_81']) && !empty($item['option_81'])):?>

                                            <div class="description__item">
                                                <div class="description__item__icon">
                                                <i class="ion-android-time"></i>
                                                </div>
                                                <?php
                                                $_strtotime = strtotime($item['option_81']);
                                                $day = date('l',$_strtotime);
                                                $day = strtolower($day);
                                                $month = date('M',$_strtotime);
                                                $month = strtolower($month);
                                                ?>
                                                <h5 title="<?php echo lang_check('cal_'.$day);?>, <?php echo lang_check('cal_'.$month);?> <?php echo date('d, g:i a', $_strtotime);?>">
                                                <?php echo lang_check('cal_'.$day);?>, <?php echo lang_check('cal_'.$month);?> <?php echo date('d, g:i a', $_strtotime);?>
                                                </h5>
                                            </div>
                                            <?php endif;?>
                                            <!-- <h5><i class="ion-ios-location"></i><?php echo _ch($item['address']);?></h5> -->

                                            <!-- <?php if(isset($item['option_81']) && !empty($item['option_81'])):?>
                                            <h5 class=""><i class="ion-ios-clock-outline"></i>
                                                <?php
                                                $_strtotime = strtotime($item['option_81']);
                                                $day = date('l',$_strtotime);
                                                $day = strtolower($day);
                                                $month = date('M',$_strtotime);
                                                $month = strtolower($month);
                                                ?>
                                                <?php echo lang_check('cal_'.$day);?>, <?php echo lang_check('cal_'.$month);?> <?php echo date('d, g:i a', $_strtotime);?> 
                                            </h5>
                                            <?php endif;?> -->
                                                                    
                                            <div class="description__item">
                                                <div class="description__item__icon">
                                                    <i class="ion-ios-location"></i>
                                                </div>
                                                <h5 title="<?php echo _ch($item['address']);?>"><?php echo _ch($item['address']);?></h5>
                                            </div>                                                              <p class=""><?php echo _ch($item['option_chlimit_8']); ?></p>
                                        </div>
                                </div>
                                </a>
                                <div class="controls-more">
                                    <ul>
                                        <li>
                                            <a href="#" data-id="<?php echo _ch($item['id']); ?>" class="add-to-favorites add-favorites-action" style="<?php echo ($item['is_favorite'])?'display:none;':''; ?>"><?php echo lang_check('Add to favorites');?></a>
                                            <a href="#" data-id="<?php echo _ch($item['id']); ?>" class="remove-from-favorites remove-favorites-action" style="<?php echo (!$item['is_favorite'])?'display:none;':''; ?>"><?php echo lang_check('Remove from favorites');?></a>
                                        </li>
                                        <li><a href="https://www.facebook.com/share.php?u=<?php echo _ch($item['url']); ?>&title=<?php echo _ch($item['option_10']); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="add-to-watchlist"><?php echo lang_check('Share to friends');?></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <?php _widget('custom_noevents_form');?>
                    <div class="row-fluid clearfix text-center prebox-pagin">
                        <div class="pagination properties wp-block default product-list-filters light-gray">
                           <?php 
                           $_pagination_links = str_replace('content', 'top_mapplacesSearchvisual', $pagination_links);
                           echo $_pagination_links; 
                           ?>
                        </div>
                    </div>
                    <div class="prebox">
                        <img src="assets/img/loading.gif" style="" alt="" class="">
                    </div>
                    <!--end results-content-->
                </div>
                <!--end tse-content-->
            </div>
            <!--end tse-scrollable-->
        </div>
        <!--end results-->
    </div>
    <!--end results-wrapper-->
</div>
<!--end hero-section-->

<script>

    var markers = new Array();
    var map;
    var marker_clusterer ;
    $(document).ready(function(){
        // option
        if($('#main-map').length){
        var myLocationEnabled = true;
        var scrollwheelEnabled = true;

        var mapOptions = {
            
            <?php if(count($has_no_results)>0 && !empty($settings_gps)): ?>
            center: new google.maps.LatLng( <?php echo $settings_gps; ?>),
            <?php elseif(config_item('custom_map_center') === FALSE): ?>
            center: new google.maps.LatLng({all_estates_center}),
            <?php else: ?>
            center: new google.maps.LatLng(<?php echo config_item('custom_map_center'); ?>),
            <?php endif; ?>
                
            zoom: {settings_zoom},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            mapTypeControl: false,
            mapTypeControlOptions: {
              mapTypeIds: c_mapTypeIds,
              position: google.maps.ControlPosition.TOP_RIGHT
            },
            streetViewControl: false,
            styles:style_map
        };

                map = new google.maps.Map(document.getElementById('main-map'), mapOptions);

                <?php foreach($all_estates as $item): ?>
                    <?php
                        if(!isset($item['gps']))break;
                    ?>

                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(<?php _che($item['gps']); ?>),
                        map: map,
                        icon: 'assets/img/markers/marker-transparent.png'
                    });
    
                    markerOptions_1 = {
                        content: "<?php echo _generate_popup($item, true); ?>",
                        disableAutoPan: false,
                        maxWidth: 0,
                        pixelOffset: new google.maps.Size(-135, -50),
                        zIndex: null,
                        infoBoxClearance: new google.maps.Size(1, 1),
                        boxClass: "infobox-wrapper",
                        enableEventPropagation: true,
                        closeBoxMargin: "0px 0px -8px 0px",
                        closeBoxURL: "assets/img/close-btn.png",
                        alignBottom: true,
                        position: new google.maps.LatLng(<?php _che($item['gps']); ?>),
                        isHidden: false,
                        pane: "floatPane",
                    };
                    marker.infobox = new InfoBox(markerOptions_1);
                    marker.infobox.isOpen = false;
                    //markers.push(marker);
                    
                    // marker
                    <?php
                    $marker_id ='';
                    if(!empty($item['gps'])) {
                        $gps = explode(', ', $item['gps']);
                        $lat = floatval($gps[0]);
                        $lng = floatval($gps[1]);
                        $marker_id = $lat.$lng;
                    }
                    ?>
                    var markerContent =
                    '<div class="marker" data-property_id="<?php _che($item['id']); ?>" data-id="<?php _che($marker_id); ?>">' +
                        '<div class="title"><?php _jse($item['option_10']); ?></div>' +
                        '<div class="marker-wrapper">' +
                            <?php if(!empty($item['option_6']) && trim($item['option_6'])==lang_check('Featured Events')):?>
                                '<div class="tag"><i class="ion-ios-star"></i></div>' +
                            <?php elseif(!empty($item['option_6']) && trim($item['option_6'])==lang_check('Events that offer points')):?>
                                '<div class="tag points"><i class="ion-ios-star"></i></div>' +
                            <?php else:?>
                            <?php endif;?>
                            
                            '<div class="pin">' +
                                '<div class="image" style="background-image: url(<?php echo _che($item['thumbnail_url']); ?>);"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
                    
                    markerOptions_2 = {
                        draggable: false,
                                content: markerContent,
                                disableAutoPan: true,
                                pixelOffset: new google.maps.Size(-21, -58),
                                position: new google.maps.LatLng(<?php _che($item['gps']); ?>),
                                closeBoxMargin: "",
                                closeBoxURL: "",
                                flat: true,
                                isHidden: false,
                                //pane: "mapPane",
                                enableEventPropagation: true
                    };
                    marker.marker = new InfoBox(markerOptions_2);      
                    marker.marker.isHidden = false;      
                    marker.marker.open(map, marker);
                    markers.push(marker);

                    // action    
                    <?php if(FALSE):?>
                    google.maps.event.addListener(marker, "click", function (e) {
                        var curMarker = this;
                        return false;
                        $.each(markers, function (index, marker) {
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
                            
                            
                            setTimeout(function(){
                                $('.infobox-wrapper').addClass("show");
                            }, 10);
                            
                        } else {
                            curMarker.infobox.close();
                            curMarker.infobox.isOpen = false;
                        }
                    });
                    <?php endif;?>
                    google.maps.event.addListener(marker.infobox,'closeclick',function(){
                        $('.marker').removeClass("active");
                    });
                    
                <?php endforeach; ?>
                
                $(".marker").live("click",function(){
                    $('.marker').removeClass("active");
                    $(this).addClass("active");
                });
                
                marker_clusterer = new MarkerClusterer(map, markers, clusterConfig);
        clusterListener = google.maps.event.addListener(marker_clusterer, 'clusteringend', function (clusterer) {
            var availableClusters = clusterer.getClusters();
            var activeClusters = new Array();
            $.each(availableClusters, function (index, cluster) {
                if (cluster.getMarkers().length > 1) {
                    $.each(cluster.getMarkers(), (function (index, marker) {
                        if (marker.marker.isHidden == false) {
                            marker.marker.isHidden = true;
                            marker.marker.close();
                        }
                    }));
                } else {
                    $.each(cluster.getMarkers(), function (index, marker) {
                        if (marker.marker.isHidden == true) {
                            marker.marker.open(map, this);
                            marker.marker.isHidden = false;
                        }
                    });
                }
            });
        });
        <?php if(FALSE):?>
        if(myLocationEnabled){
            var controlDiv = document.createElement('div');
            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
            HomeControl(controlDiv, map)
            }
        <?php endif;?>
        }
/*
        var controlDiv2 = document.createElement('div');
         controlDiv2.index = 2;
         map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv2);
         AddControl(controlDiv2, map)
         */
        if(rectangleSearchEnabled)
         {
             var controlDiv2 = document.createElement('div');
             controlDiv2.index = 2;
             map.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv2);
             RectangleControl(controlDiv2, map)
         } 


    })
$(function () {  
    $(".marker").on("click", function(){
        $('.marker').removeClass("active");
        $(this).addClass("active");
    });
    
    $('body').on('click', '.marker', function(){
        var property_id = $(this).attr('data-property_id')
        reload_popup(property_id)
    });
});

</script>

<script>
    $('document').ready(function(){
        if($('.results_conteiner').length<1) {
            $('#mapplaces_search_results').append('<div class="wrap-content" style="display:none !important;"><div class="container"></div></div>')
        }
        
        setTimeout(function(){ trackpadScroll("initialize");}, 500)
        /* height fore reasults box */
                $('.searchform-toggle').removeClass('hidden');
    })
</script>
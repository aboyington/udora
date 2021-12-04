<?php

$get_location_string ='';
$get_location_city ='';
$get_location_region ='';
$get_location_country ='';

// get user ip

/* ip-api.com */

$ip = $_SERVER['REMOTE_ADDR'];
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
    $get_location_string = $query ['city']. ", ".$query['country'];
    $get_location_city = $query ['city'];
    $get_location_region = $query['regionName'];
    $get_location_country = $query['country'];
}
    
/* geoPlugin */
/*
$CI =& get_instance();
$CI->load->library('geoplugin');
$CI->geoplugin->locate();
if($CI->geoplugin->city) {
    $get_location_string = $CI->geoplugin->city. ", ". $CI->geoplugin->region. ", ".$CI->geoplugin->countryName;
    $get_location_city =  $CI->geoplugin->city;
    $get_location_region = $CI->geoplugin->region;
    $get_location_country = $CI->geoplugin->countryName;
}
*/  
?>

<form class="check-form">
 <div class="input-search-wrapper col-xs-11 col-sm-8 col-md-12 clearfix">
    <div class="input-wrapper advanced-search col-xs-12 col-md-8">
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
        
        <div class="second-group clearfix">
        	<input type="text" class="form-control search_option_location_second" oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'<?php echo lang_check("Please Populate field Location");?>');" id="search_option_location_second" value="<?php echo $get_location_string;?>">
        	<input type="hidden" name="region_name" value="<?php echo $get_location_region; ?>">
        	<input type="hidden" name="country" value="<?php echo $get_location_country; ?>">
        	<input type="hidden" class="form-control search_option_smart search_option_smart_second" placeholder="<?php echo lang_check("Search events or categories");?>">
        
        <script>
            $(function(){
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            var placeSearch, autocomplete;
                var componentForm = {
                  street_number: 'long_name',
                  route: 'long_name',
                  locality: 'long_name',
                  administrative_area_level_1: 'long_name',
                  country: 'long_name',
                  postal_code: 'long_name'
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
                (document.getElementById('search_option_location_second')),
                {types: ['geocode']}
                );

            // fields in the form.
            autocomplete.addListener('place_changed', function(){
                 var place = autocomplete.getPlace();
                 $('#search_option_location').val($('#search_option_location_second').val());
                
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
            
            $('#search_option_location_second').change(function(){
                $('#search_option_location').val($('#search_option_location_second').val());
            })
            
        })
        </script>
        
        <div class="dropdown-button-form"><span class="caret"></span></div>
        </div>
        <div class="form search-form inputs-underline display-none">
        <form>
            <input id="rectangle_ne" type="text" class="hidden" />
            <input id="rectangle_sw" type="text" class="hidden" />
            <div class="hidden">
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
            <div class="form-group search_option_smart-group">
                <input type="text" class="form-control" name="search_option_smart" value="{search_query}" id="search_option_smart" placeholder="<?php echo lang_check('Looking for...');?>">
                <div class="dropdown-close"><span class="fa fa-times"></span></div>
            </div>
            <!--end form-group-->
            <div class="row">

                <!--<div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <div class="dropdown dropdown-field">
                            <a href="#" class="dropdown-field-toggle">
                                <span class="value"><?php echo lang_check('Category');?> </span> <span class="caret"></span>
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
                <div class="col-lg-6 col-md-12 search_option_location-group hidden hidden-md">
                     <div class="form-group search_option_location-box">
                        <input type="text" class="form-control" name="search_option_location" value="<?php echo $get_location_string;?>" id="search_option_location" placeholder="<?php echo lang_check('Location');?>">
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
                <div class="col-lg-12 col-md-12 category-group">
                    <div class="form-group">
                        <div class="dropdown dropdown-field">
                            <div class="">
                                <?php if(config_item('tree_field_enabled') === TRUE):?>
                                <?php
                                
                                    $CI =& get_instance();
                                    $CI->load->model('treefield_m');
                                    $field_id = 79;
                                    $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                                    $drop_options[''] = lang_check('Category');
                                    
                                    $drop_selected = array();
                                    echo '<div class="tree TREE-GENERATOR">';
                                    echo '<div class="field-tree">';
                                    echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                                    echo '</div>';
                                    echo '</div>';
                                ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!--end form-group-->
                </div>
                <!--end col-md-6-->

                <div class="col-md-12 col-sm-12 hidden-sm hidden-xs">
                    <div class="form-group">
                        <input type="text" name="daterange-home" id="search_option_81_82" placeholder="<?php echo lang_check('All Dates');?>" />
                    </div>
                    <!--end form-group-->
                </div>
            
                <div class="col-md-12 col-sm-12 visible-sm visible-xs">
                    <div class="form-group">
                        <select class="form-control selectpicker drop-custom" name="trigger_option_81_82" id="trigger_option_81_82">
                            <option value=""><?php echo lang_check('All Dates');?></option>
                            <option value="today"><?php echo lang_check('Today');?></option>
                            <option value="this_week"><?php echo lang_check('This Week');?></option>
                            <option value="this_month"><?php echo lang_check('This Month');?></option>
                            <option value="next_month"><?php echo lang_check('Next Month');?></option>
                        </select>
                    </div>
                    <!--end form-group-->
                </div>
            </div>
            <!--end row-->
            <div class="row">
           
            </div>
            <!--end row-->
            <!--end form-group-->
        </form>
        <!--end form-hero-->
    </div>
    </div>
    <div class="search-wrapper">
        <a href="#" id="search-start-ajax" ><button class="btn-search"><i class="material-icons">search</i></button></a>
    </div>
</div>
</form>

<script>
$(document).ready(function(){
    $('.search_option_smart_second').on('keyup change', function(){
        $('#search_option_smart').val($(this).val());
    })
    
    $('#search-start-ajax').on('click', function(e){
        e.preventDefault();
        var f = $('#search_option_location_second').closest('form')[0];
        if (f.checkValidity()) {
            manualSearch(0, 'undefined', 'undefined', true)
        } else {
            f.reportValidity();
        }
    })
    
    $('input#search_option_81_82').daterangepicker({
        "ranges": {
            //'Today': [moment(), moment()],
            'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
            'This Month': [moment().add('month'), moment().endOf('month')],
            'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
        },
        locale: {
            format: 'MM-DD-YYYY HH:mm:ss',
            cancelLabel: 'Clear',
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
        
    /* trigger_option_81_82 */
    
    $('#trigger_option_81_82').change(function() {
        switch ($(this).val()) {
            case 'today': 
                            $('input#search_option_81_82').data('daterangepicker').setStartDate("<?php echo date('m/d/Y');?>");
                            $('input#search_option_81_82').data('daterangepicker').setEndDate("<?php echo date('m/d/Y');?>");
                            break;
            case 'this_week': 
                            $('input#search_option_81_82').data('daterangepicker').setStartDate("<?php echo date('m/d/Y');?>");
                            $('input#search_option_81_82').data('daterangepicker').setEndDate("<?php echo date('m/d/Y', strtotime('+1 week'));?>");
                            break;
            case 'this_month': 
                            $('input#search_option_81_82').data('daterangepicker').setStartDate("<?php echo date('m/d/Y');?>");
                            $('input#search_option_81_82').data('daterangepicker').setEndDate("<?php echo date('m/d/Y', strtotime('+1 month'));?>");
                            break;
            case 'next_month': 
                            $('input#search_option_81_82').data('daterangepicker').setStartDate("<?php echo date('m/d/Y', strtotime('+1 month'));?>");
                            $('input#search_option_81_82').data('daterangepicker').setEndDate("<?php echo date('m/d/Y', strtotime('+2 month'));?>");
                            break;

            default:
                    $('input#search_option_81_82').val('');
                    break;
        }
        
    })
    
    $('.home-wrapper .main-home-container .input-search-wrapper .dropdown-button-form').click(function(){
        $('.home-wrapper .main-home-container .input-search-wrapper .search-form').slideDown()
    })
    
    
    $('.home-wrapper .main-home-container .input-search-wrapper .dropdown-close').click(function(){
        $('.home-wrapper .main-home-container .input-search-wrapper .search-form').slideUp()
    })
    
})
</script>
<?php
/*
Widget-title: Search form
Widget-preview-image: /assets/img/widgets_preview/top_search.jpg
*/
?>

<div class="box-content advanced-search widget_top_search">
<div class="form search-form inputs-underline">
    <form>
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
            <input type="text" class="form-control" name="search_option_smart" value="{search_query}" id="search_option_smart" placeholder="{lang_CityorCounty}">
        </div>
        <!--end form-group-->
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <select class="form-control selectpicker" name="search_option_4" id="search_option_4">
                        {options_values_4}
                    </select>
                </div>
                <!--end form-group-->
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <select class="form-control selectpicker" name="search_option_2" id="search_option_2">
                        {options_values_2}
                    </select>
                </div>
                <!--end form-group-->
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <select id="search_option_58" class="form-control selectpicker" placeholder="{options_name_58}">
                        <option value="">{options_name_58}</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>
                <!--end form-group-->
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <select class="form-control selectpicker" name="search_option_3" id="search_option_3">
                        {options_values_3}
                    </select>
                </div>
                <!--end form-group-->
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="search_option_53" value="<?php echo search_value('53'); ?>"  id="search_option_53" placeholder="{options_name_53}">
                </div>
                <!--end form-group-->
            </div>
            <!--end row-->
            <div class="col-md-4 col-sm-6">
                <div class="form-group">
                    <select class="form-control selectpicker" name="search_option_54" id="search_option_54">
                        {options_values_54}
                    </select>
                </div>
                <!--end form-group-->
            </div>
        </div>
        <!--end row-->
        <div class="clearfix">
            <div class="pull-right form-group form-group-btns">
                <button type="button" class="btn sidebar-button accent-button" id="search-start"><?php echo lang_check('Search');?></button>
                <?php if(file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>
                    <button  id="search-save"  type="button" class="btn sidebar-button accent-button btn-custom-warning"><?php echo lang_check('Save');?></button>
                <?php endif; ?>
            </div>
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
                format: 'MM-DD-YYYY HH:mm:ss'
            },
            "startDate": "<?php echo (search_value('81_from')) ? date('m/d/Y', strtotime(search_value('81_from'))) : '12/10/2016';?>",
            "endDate": "<?php echo (search_value('82_to')) ? date('m/d/Y', strtotime(search_value('82_to'))) : '12/10/2017';?>",
            "linkedCalendars": false,
            "showCustomRangeLabel": false,
            "alwaysShowCalendars": true,
            "opens": "right",
            "drops": "down"
        }, function (start, end, label) {
            //console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        });
    });
    </script>
    <!--end form-hero-->
</div>
</div>
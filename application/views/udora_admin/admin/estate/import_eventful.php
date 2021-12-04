<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Eventful import')?></h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <?php echo form_open('admin/dashboard/search');?>
            <div class="input-group">
              	<input type="text" class="form-control col-md-7 col-xs-12" name="search" placeholder="<?php echo lang_check('Search')?>" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Go!</button>
                </span>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Import data')?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br/>
                <div class="padd-alert">
                 <?php echo validation_errors() ?>
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php echo $this->session->flashdata('message') ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error'); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                        <p class="label label-important validation"> <?php echo $error; ?> </p>
                    <?php endif; ?>
                    <?php if (!empty($message)): ?>
                        <p class="label label-important validation"> <?php echo $message; ?> </p>
                    <?php endif; ?>
                </div>
                <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role' => 'form')) ?>                              
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Eventful categories') ?></label>
                         <div class="col-lg-10">
                             <?php echo form_dropdown('event_category', array_merge(array('' => 'Select category'), $event_categories), $this->input->post('event_category'), 'class="form-control ui-state-valid" id="selectEvent_category"'); ?>
                         </div>
                     </div>
                     <div class="form-group TREE-GENERATOR hidden">
                         <label class="col-lg-2 control-label">
                             <?php echo lang_check('Category into import') ?>
                             <div class="ajax_loading"> </div>
                         </label>
                         <div class="col-lg-10">
                             <?php echo form_input('option79_1',  $this->input->post('option79_1') ? $this->input->post('option79_1') : '', 'id="input_option79_1" class="form-control ui-state-valid"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Location')?></label>
                         <div class="col-lg-10">
                            <?php echo form_input('location',  $this->input->post('location') ? $this->input->post('location') : '', 'id="input_location" class="form-control ui-state-valid" placeholder="London, United Kingdom"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Eventful limit events') ?></label>
                         <div class="col-lg-10">
                             <?php echo form_input('eventful_limit_page',  $this->input->post('eventful_limit_page') ? $this->input->post('eventful_limit_page') : 1, 'class="form-control ui-state-valid"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Eventful offset events') ?></label>
                         <div class="col-lg-10">
                             <?php echo form_input('eventful_offset_page',  $this->input->post('eventful_offset_page') ? $this->input->post('eventful_offset_page') : 0, 'class="form-control ui-state-valid"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Pages available (250 events per page)')?></label>
                         <div class="col-lg-10">
                             <span id="pages_available"><span class="label label-danger"><?php echo lang_check('eventful category doesn`t selected');?></span></span>
                         </div>
                     </div>
                     <div class="form-group clearfix">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Max images per listing')?></label>
                         <div class="col-lg-10">
                             <?php echo form_input('max_images', $this->input->post('max_images') ? $this->input->post('max_images') : '1', 'class="form-control ui-state-valid"');?>
                         </div>
                     </div>  
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Overwrite existing')?></label>
                         <div class="col-lg-10">
                         <?php echo form_checkbox('overwrite_existing', '1', false, 'id="root_country"')?>
                         </div>
                     </div>
                     <div class="form-group">
                         <div class="col-lg-offset-2 col-lg-10">
                             <?php echo form_submit('submit', lang_check('Import'), 'class="btn btn-primary-blue"') ?>
                             <a href="<?php echo site_url('admin/estate/') ?>" class="btn btn-danger" type="button"><?php echo lang('Cancel') ?></a>
                             <img src="<?php echo base_url('adminudora-assets/img/loading.gif')?>" id="pre_loading_gif"  style="display:none;height: 20px; margin-left: 5px;" alt="" />
                         </div>
                     </div>
                     <?php echo form_close() ?>
            </div>
            <div class="clearfix"></div>
            <div class="widget-foot">
                        <?php if(isset($imports)): ?>                     
                            <p><?php _l('All property'); ?>: <?php echo count($imports);?></p>
                            <p><?php _l('Added new'); ?>: <?php echo count($imports) - $skipped;?></p>
                            <p><?php _l('Overwrite'); ?>: <?php echo  $count_exists_overwrite;?></p>
                            <br/>
                            <p><?php _l('Skipped'); ?>: <?php echo $skipped;?></p>
                            <p><?php _l('Errors'); ?>: <?php echo $skipped-$count_exists;?></p>
                            <p><?php _l('Exists skipped'); ?>: <?php echo $count_exists;?></p>
                            <br/>
                        <?php endif; ?>

                            <?php if (!empty($imports)): ?>
                            <p><?php _l('Update/Import completed'); ?>:</p>
                            <table class="table table-striped">
                                <tr>
                                    <th>#</th>
                                    <th><?php _l('Address'); ?></th>
                                </tr>
                                <?php foreach ($imports as $item): ?>
                                    <tr>
                                        <td><?php echo $item['id']; ?></td>
                                        <td>
                                           <?php if(!empty($item['preview_id'])):?>
                                            <a href="<?php echo site_url('admin/estate/edit/'.$item['preview_id']); ?>"><?php echo $item['address']; ?></a>
                                           <?php else:?>
                                            <?php echo $item['address']; ?>
                                           <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <br />
                            <a class="label label-warning" target="_blank" href="https://api.eventful.com/docs/events/search"><?php _l('Guides'); ?></a>
                            <br /><br />
                        <?php endif; ?>
                    </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#selcect_deselect_chackbox').click(function (e) {
            e.preventDefault();
            $(".check-box-places").prop('checked', $(this).attr('data-status'));

            if ($(this).attr('data-status') == 'checked') {
                $(this).attr('data-status', '')
            } else {
                $(this).attr('data-status', 'checked')
            }
        })
    })
</script>

<script type="text/javascript">

    /* [START] TreeField */
    
    $(function() {
        $(".TREE-GENERATOR select").change(function(){
            var s_value = $(this).val();
            var s_name_splited = $(this).attr('name').split("_"); 
            var s_level = parseInt(s_name_splited[3]);
            var s_lang_id = s_name_splited[1];
            var s_field_id = s_name_splited[0].substr(6);
            // console.log(s_value); console.log(s_level); console.log(s_field_id);
            
            load_by_field($(this));
            
            // Reset child selection and value generator
            var generated_val = '';
            var last_selected_numeric = '';
            $(this).parent().parent()
            .find('select').each(function(index){
                // console.log($(this).attr('name'));
                if(index > s_level)
                {
                    $(this).html('<option value=""><?php echo lang_check('No values found'); ?></option>');
                    $(this).val('');
                }
                else if($(this).val() != '')
                {
                    last_selected_numeric = $(this).val();
                    generated_val+=$(this).find("option:selected").text()+" - ";
                }
                    
            });

            $("#inputOption_"+s_lang_id+"_"+s_field_id).attr('rel', last_selected_numeric);
            $("#inputOption_"+s_lang_id+"_"+s_field_id).val(generated_val);
            $("#inputOption_"+s_lang_id+"_"+s_field_id).trigger("change");

        });
        
        // Autoload selects
        $(".TREE-GENERATOR input.tree-input-value").each(function(index_1){
            var s_values_splited = ($(this).val()+" ").split(" - "); 
//            $.each(s_values_splited, function( index, value ) {
//                alert( index + ": " + value );
//            });
            if(s_values_splited[0] != '')
            {
                var first_select = $(this).parent().parent().find('select:first');
                var find_selected = first_select.find('option').filter(function () { return $(this).html() == s_values_splited[0]; });
                find_selected.attr('selected', 'selected');
                
                var index_tree = find_selected.val();
                if (typeof index_tree !== typeof undefined && index_tree !== false)
                {
                    if($(this).attr('rel') != index_tree)
                    {
                        $(this).attr('rel', index_tree);
                        $(this).trigger("change");
                    }
                }

                load_by_field(first_select, true, s_values_splited);
            }
            
            //console.log('value: '+s_values_splited[0]);
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
            $.getJSON( "<?php echo site_url('privateapi/get_level_values_select'); ?>/"+s_lang_id+"/"+s_field_id+"/"+s_value+"/"+parseInt(s_level+1), function( data ) {
                //console.log(data.generate_select);
                //console.log("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
                ajax_indicator.css('display', 'none');
                
                select_element.html(data.generate_select);
                
                if(autoselect_next)
                {
                    if(s_values_splited[s_level+1] != '')
                    {
                        var find_selected = select_element.find('option').filter(function () { return $(this).html() == s_values_splited[s_level+1]; });
                        
                        find_selected.attr('selected', 'selected');
                        var index_tree = find_selected.val();
                        if (typeof index_tree !== typeof undefined && index_tree !== false)
                        {
                            var input_element = field_element.parent().parent().find("input.tree-input-value");

                            if(input_element.attr('rel') != index_tree)
                            {
                                input_element.attr('rel', index_tree);
                                $(input_element).trigger("change");
                            }
                        }
                        
                        load_by_field(select_element, true, s_values_splited);
                    }
                }
            });
        }
    }
    
    function load_and_select_index(field_element, field_select_id, field_parent_select_id)
    {
        var s_name_splited = field_element.attr('name').split("_"); 
        var s_level = parseInt(s_name_splited[3]);
        var s_lang_id = s_name_splited[1];
        var s_field_id = s_name_splited[0].substr(6);
        
        // Load values for current select
        var ajax_indicator = field_element.parent().parent().parent().find('.ajax_loading');
        if(s_level == 0)$("#inputOption_"+s_lang_id+"_"+s_field_id).attr('value', '');

        ajax_indicator.css('display', 'block');
        $.getJSON( "<?php echo site_url('privateapi/get_level_values_select'); ?>/"+s_lang_id+"/"+s_field_id+"/"+field_parent_select_id+"/"+parseInt(s_level), function( data ) {
            ajax_indicator.css('display', 'none');
            
            field_element.html(data.generate_select);
            //console.log(field_select_id);
            if(isNumber(field_select_id))
                field_element.val(field_select_id);
            else
                field_element.val('');
            
            var generated_val = '';
            var last_selected_val = '';
            
            field_element.parent().parent()
            .find('select').each(function(index){
                if($(this).val() != '' && $(this).val() != null)
                {
                    last_selected_val = $(this).val();
                    generated_val+=$(this).find("option:selected").text()+" - ";
                }
            });

            if(generated_val.length > $("#inputOption_"+s_lang_id+"_"+s_field_id).val().length)
            {
                $("#inputOption_"+s_lang_id+"_"+s_field_id).attr('rel', last_selected_val);
                $("#inputOption_"+s_lang_id+"_"+s_field_id).val(generated_val);
                $("#inputOption_"+s_lang_id+"_"+s_field_id).trigger('change');
            }

        });

    }
    
    function isNumber(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }
    
    /* [END] TreeField */

</script>

<script>

$(document).ready(function(){
    
    $('#selectEvent_category, #input_location').change(function(){
        if($('#selectEvent_category').val() == '') return false;
        
        $('#input_option79_1').val($('#selectEvent_category option[value="'+$('#selectEvent_category').val()+'"]').text()+' - ' );
        
        var data = [];
        data.push({name: 'eventful_category', value: $('#selectEvent_category').val()});
        data.push({name: 'location', value: $('#input_location').val()});
        
        var eventful_categories = $(this).val();
        $('#pre_loading_gif').show();
        $('#pages_available').html('<span class="label label-warning"><?php echo lang_check('please wait, available pages calculation');?></span>');
        $.post("<?php echo site_url('privateapi'); ?>/eventful_get_count_pages/",data, function(data){
            
            if(data.success) {
                $('#pages_available').html(data.eventful_get_count_pages);
            } else {
               $('#pages_available').html('<span class="label label-danger"><?php echo lang_check('can`t get available pages');?></span>');
            }
            
            $('#pre_loading_gif').hide();
        });
    })
    
    $('#selectEvent_category').trigger('change');
})


</script>

<style type="text/css">
    .table.table-striped td {
        font-size: 14px;
        vertical-align: middle;
    }
    
    .table.table-striped td a:hover {
        text-decoration: underline!important;
    }
    
</style>
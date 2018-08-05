<div class="page-title">
    <div class="title_left">
        <h3><?php echo empty($item->id_dependent_field) ? lang_check('Add dependent field') : lang('Edit dependent field').' #' . $item->id_dependent_field.''?></h3>
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
                <h2><?php echo lang('Dependent field data')?></h2>
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
                <?php echo validation_errors()?>
                <?php if($this->session->flashdata('message')):?>
                <?php echo $this->session->flashdata('message')?>
                <?php endif;?>
                <?php if($this->session->flashdata('error')):?>
                <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                <?php endif;?>
                <!-- Form starts.  -->
          <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              


                                
                                <div class="form-group">
                                  <label class="col-lg-3 control-label"><?php _l('Dependent field')?></label>
                                  <div class="col-lg-9">
                                  <?php if( empty($item->id_dependent_field) ): ?>
                                    <?php echo form_dropdown('field_id', $available_fields, $this->input->post('field_id') ? $this->input->post('field_id') : $item->field_id, 'class="form-control"')?>
                                  <?php else: ?>
                                    <?php echo form_dropdown('field_id_x', $available_fields, $this->input->post('field_id') ? $this->input->post('field_id') : $item->field_id, 'class="form-control" disabled')?>
                                    <?php echo form_input('field_id', $this->input->post('field_id') ? $this->input->post('field_id') : $item->field_id, 'class="hidden"')?>
                                  <?php endif; ?>
                                  </div>
                                </div>

                                <?php if( empty($item->id_dependent_field) ): ?>
                                <div class="form-group">
                                  <label class="col-lg-3 control-label"></label>
                                  <div class="col-lg-9">
                                    <span class="label label-danger"><?php _l('After saving, you can define other parameters');?></span>
                                  </div>
                                </div>
                                <?php else: 
                                    $depended_field = $this->option_m->get($item->field_id);
                                    if(!empty($depended_field)):
                                ?>
                                
                                <?php if($depended_field->type == 'DROPDOWN' || $depended_field->type == 'DROPDOWN_MULTIPLE'): ?>
                                <div class="form-group">
                                  <label class="col-lg-3 control-label"><?php _l('Selected index')?></label>
                                  <div class="col-lg-9">
                                    <?php echo form_dropdown('selected_index', $available_indexes, $this->input->post('selected_index') ? $this->input->post('selected_index') : $item->selected_index, 'class="form-control"')?>
                                  </div>
                                </div>
                                <?php elseif($depended_field->type == 'TREE'): ?>
                                <div class="form-group search-form">
                                  <label class="col-lg-3 control-label"><?php _l('Selected index')?></label>
                                  <div class="col-lg-9">
                <!-- [START] TreeSearch -->
                <?php if(config_item('tree_field_enabled') === TRUE):?>
                <?php
                
                    $CI =& get_instance();
                    $CI->load->model('treefield_m');
                    $field_id = $depended_field->id;
                    $lang_id = $content_language_id;
                    $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                    $drop_selected = array();
                    echo '<div class="tree TREE-GENERATOR tree-'.$field_id.'">';
                    echo '<div class="field-tree">';
                    echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                    echo '</div>';
                    
                    $levels_num = $CI->treefield_m->get_max_level($field_id);
                    
                    if($levels_num>0)
                    for($ti=1;$ti<=$levels_num;$ti++)
                    {
                        $lang_empty = lang_check('treefield_'.$field_id.'_'.$ti);
                        if(empty($lang_empty))
                            $lang_empty = lang_check('Please select parent');
                        
                        echo '<div class="field-tree">';
                        echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_'.$ti, array(''=>$lang_empty), array(), 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_'.$ti.'"');
                        echo '</div>';
                    }
                    echo '</div>';
                
                ?>
                
                <script language="javascript">
                
                $(function() {
                    var load_index = '<?php echo set_value('selected_index', $item->selected_index); ?>';
                    
                    var load_val = '<?php 
                    $treefield_id = set_value('selected_index', $item->selected_index);
                    
                    if(!empty($treefield_id))
                    {
                        $path = $CI->treefield_m->get_path($field_id, $treefield_id, $lang_id);
                        echo $path;
                    }
                    ?>';
                    
                    $('#input_county_affiliate_values').val(load_index);
                    
                    var s_values_splited = (load_val+" ").split(" - "); 
//            $.each(s_values_splited, function( index, value ) {
//                alert( index + ": " + value );
//            });
                    if(s_values_splited[0] != '')
                    {
                        var first_select = $('.tree-<?php _che($item->field_id); ?>').find('select:first');
                        first_select.find('option').filter(function () { return $(this).html() == s_values_splited[0]; }).attr('selected', 'selected');
                        
                        if(first_select.length > 0)
                            load_by_field(first_select, true, s_values_splited);
                    }
                });
                
                </script>
                <?php endif; ?>
                <!-- [END] TreeSearch -->
                                  
                                    <?php echo form_input('selected_index', $this->input->post('selected_index') ? $this->input->post('selected_index') : $item->selected_index, 'class="form-control hidden" id="input_county_affiliate_values"')?>
                                  </div>
                                </div>
                                <?php else: ?>
                                <div class="form-group">
                                  <label class="col-lg-3 control-label"> </label>
                                  <div class="col-lg-9">
                                    <span class="label label-warning"><?php _l('Type is not suitable'); echo ' - '.$depended_field->type;?></span>
                                  </div>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                
                                <hr />
                                <h5><?php _l('Hidden fields under selected')?></h5>
                                <hr />
                                
                                <?php foreach($fields_under_selected as $key=>$field): ?>
                                
                                <?php if($field->type == 'CATEGORY'): ?>
                                <hr />
                                <?php endif; ?>
                                
                                <div class="form-group">
                                  <label class="col-lg-3 control-label"><?php echo $field->option; ?></label>
                                  <div class="col-lg-9">
                                    <?php 
                                    
                                    $val = $this->input->post('field_'.$field->id);
                                    
                                    if(empty($val))
                                    {
                                        if(isset($item->{'field_'.$field->id}))
                                        $val = $item->{'field_'.$field->id};
                                    }
                                    
                                    echo form_checkbox('field_'.$field->id, '1', $val, 'class="type_'.$field->type.'"')?>
                                  </div>
                                </div>
                                
                                <?php if($field->type == 'CATEGORY'): ?>
                                <hr />
                                <?php endif; ?>
                                
                                <?php endforeach; ?>
                                
                                <?php endif; ?>
<div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-lg-offset-3 col-lg-9">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                                    <a href="<?php echo site_url('admin/estate/dependent_fields')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                                  </div>
                                </div>
                       <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
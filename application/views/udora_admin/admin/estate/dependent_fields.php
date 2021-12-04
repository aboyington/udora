<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Dependent fields')?></h3>
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

<!-- Add page / events button -->
<div class="x_panel">
    <div class="x_title">
        <h2><?php echo lang_check('Quick Add');?></h2>
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
       <?php echo anchor('admin/estate/edit_dependent_field', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add dependent field'), 'class="btn btn-primary-blue"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Dependent fields')?></h2>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php _l('Field');?></th>
                            <th data-hide="phone"><?php _l('Value');?></th>
                            <th data-hide="phone"><?php _l('Hidden count');?></th>
                        	<th><?php _l('Edit');?></th>
                            <?php if($this->session->userdata('type') != 'AGENT_ADMIN'): ?>
                        	<th><?php _l('Delete');?></th>
                            <?php endif;?> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings)): foreach($listings as $item):
                        
                        $depended_field = $this->option_m->get($item->field_id);
                        if($depended_field->type == 'TREE' && config_db_item('tree_field_enabled') === FALSE || 
                           $depended_field->type == 'TREE' && config_db_item('dependent_treefield') === FALSE)
                            continue;
                        ?>
                                    <tr>
                                    	<td><?php echo '<a href="'.site_url('admin/estate/edit_dependent_field/'.$item->id_dependent_field).'">'.$item->option.'</a>'; ?></td>
                                        <td>
                                        <?php 
                                        $values = explode(',', $item->values);

                                        if(isset($values[$item->selected_index]))
                                        {
                                            echo $values[$item->selected_index]; 
                                        }
                                        elseif($depended_field->type == 'DROPDOWN')
                                        {
                                            echo '<span class="label label-danger">'.lang_check('Wrong value').'</span>';
                                        }
                                        elseif($depended_field->type == 'TREE')
                                        {   
                                            $CI =& get_instance();
                                            $CI->load->model('treefield_m');
                                            $path = $CI->treefield_m->get_path($item->field_id, $item->selected_index, $content_language_id);
                                            
                                            if(substr($path, -2, 2) == '- ')
                                                $path = substr($path, 0, -2);
                                            
                                            if(!empty($path))
                                            {
                                                echo $path;
                                            }
                                            else
                                            {
                                                echo '<span class="label label-warning">'.lang_check('Wrong value').'</span>';
                                            }
                                            
                                        }
                                        else
                                        {
                                            echo 'ERROR';
                                        }
                                        ?>
                                        </td>
                                        <td>
                                        <?php 
                                        $values = explode(',', $item->hidden_fields_list);
                                        
                                        if(count($values) > 0 && is_numeric($values[0]))
                                        {
                                            echo count($values);
                                        }
                                        else
                                        {
                                            echo '-';
                                        }
                                        
                                        
                                        ?>
                                        </td>
                                        <?php if($this->session->userdata('type') == 'ADMIN'): ?>
                                        <td><?php echo btn_edit_udora('admin/estate/edit_dependent_field/'.$item->id_dependent_field)?> </td>
                                    	<td><?php echo btn_delete_udora('admin/estate/delete_dependent_field/'.$item->id_dependent_field)?></td>
                                        <?php endif;?> 
                                    </tr>
                        <?php endforeach;?>
                        <?php else:?>
                                    <tr>
                                    	<td colspan="4"><?php _l('We could not find any'); ?></td>
                                    </tr>
                        <?php endif;?>           
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


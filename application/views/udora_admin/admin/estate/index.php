<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Estates')?></h3>
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
        <?php echo anchor('admin/estate/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang('Add a estate'), 'class="btn btn-primary-blue"')?>
        <div class="dropdown pull-right hidden-emptydropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownImport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-arrow-down"></i>&nbsp;&nbsp;<?php echo _l('Imports');?>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownImport">
                <?php if(config_db_item('csv_import_enabled') == TRUE && ($this->session->userdata('type') == 'ADMIN' || $this->session->userdata('type') == 'AGENT_ADMIN')): ?>
                   <li> <?php echo anchor('admin/estate/import_csv/', lang_check('Import from CSV'), '')?></li>
                <?php endif;?>
                <?php if(config_db_item('import_foursquare') == TRUE): ?>
                    <li><?php echo anchor('admin/estate/import_foursquare/', lang_check('Import from foursquare'), 'class=""')?></li>
                <?php endif;?>
                <?php if(config_db_item('import_google_places') == TRUE): ?>
                    <li><?php echo anchor('admin/estate/import_google_places/', lang_check('Import from google places'), 'class=""')?></li>
                <?php endif;?>
                <?php if(file_exists(APPPATH.'libraries/Xml2u.php') && $this->session->userdata('type')=='ADMIN'): ?>
                    <li><?php echo anchor('admin/estate/import_xml2u/', lang_check('Import from xml2u'), '')?></li>
                <?php endif;?>    
                <?php if(file_exists(APPPATH.'libraries/Eventful.php') && $this->session->userdata('type')=='ADMIN'): ?>
                    <li><?php echo anchor('admin/estate/import_eventful/', lang_check('Import from eventful'), '')?></li>
                <?php endif;?>  
                <li><?php echo anchor('admin/estate/import_eventbrite/', lang_check('Import from eventbrite'), '')?></li>
            </ul>
        </div>
        <div class="dropdown pull-right hidden-emptydropdown" style="margin-right:10px;">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownExport" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-arrow-up"></i>&nbsp;&nbsp;<?php echo _l('Exports');?>
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownExport">
                <?php if(config_db_item('csv_import_enabled') == TRUE && ($this->session->userdata('type') == 'ADMIN' || $this->session->userdata('type') == 'AGENT_ADMIN')): ?>
                    <li><?php echo anchor('admin/estate/export_csv/', lang_check('Export CSV'), '')?></li>
                <?php endif;?>
                <?php if(file_exists(APPPATH.'libraries/Xml2u.php') && $this->session->userdata('type')=='ADMIN'): ?>
                    <li> <?php echo anchor('api/xml2u/', lang_check('Export xml2u'), '')?></li>
                <?php endif;?>    
            </ul>
        </div>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Estates')?></h2>
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
                <form class="search-admin form-inline" action="<?php echo site_url($this->uri->uri_string()); ?>" method="GET" autocomplete="off">
                  <div class="form-group">
                    <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('Smart item search'); ?>" type="text" />
                  </div>
                  <div class="form-group">
                    <?php echo form_dropdown('field_2', $this->option_m->get_field_values($content_language_id, 2, lang_check('Location Type')), set_value_GET('field_2', '', true), 'class="form-control"'); ?>
                  </div>
                  <div class="form-group">
                    <?php if($settings['template'] == 'udora'):?> 
                        <?php
                        $tree_field_id = 79;
                        $values = array();
                        $CI = &get_instance();
                        $this->load->model('treefield_m');
                        $this->load->model('file_m');
                        $check_option = $CI->treefield_m->get_lang(NULL, FALSE, $content_language_id);
                        foreach ($check_option as $key => $value) {
                            if($value->field_id==$tree_field_id){
                                $values['"field_79":"'.$value->value_path]= $value->value_path;
                            }
                        }
                        ?>
                        <?php echo form_dropdown('json_object', array_merge(array(''=>lang_check('Category')),$values), set_value_GET('json_object', '', true), 'class="form-control"'); ?>
                    <?php else:?>
                        <?php echo form_dropdown('field_2', $this->option_m->get_field_values($content_language_id, 2, lang_check('Type')), set_value_GET('field_2', '', true), 'class="form-control"'); ?>
                    <?php endif;?>
                  </div>
                  <button type="submit" class="btn btn-primary-blue"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>
                </form>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th data-priority="1">#</th>
                            <th data-priority="1"><?php echo lang('Address');?></th>
                            <th data-priority="2"><?php echo lang('Agent');?></th>
                            <!-- Dynamic generated -->
                            <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                            <th data-priority="3"><?php echo $row->option?></th>
                            <?php endforeach;?>
                            <!-- End dynamic generated -->
                            <th data-priority="3" data-orderable="false"><?php echo lang_check('Views');?></th>
                            <th data-priority="2" data-orderable="false"><?php echo lang_check('Preview');?></th>
                            <th  data-priority="1" data-orderable="false"><?php echo lang('Edit');?></th>                       
                          
                            <?php if(config_item('status_enabled') === TRUE && 
                                        ($this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE' || 
                                         $this->session->userdata('type') == 'ADMIN'
                                        )):?>
                            <th><?php _l('Status');?></th>
                            <?php elseif(check_acl('estate/delete')):?><th data-orderable="false" data-priority="2"><?php echo lang('Delete');?></th>
                            <?php endif;?>
                            
                            <?php if(check_acl('estate/delete_multiple')):?>
                            <th data-priority="1" data-orderable="false">
                            <a href="#" data-status='' class="btn btn-primary-blue selcect_deselect_chackbox" style="padding: 0px 5px;" type="button"><i class="icon-check"></i></a>
                            <button type="submit" onclick="return confirm('<?php _l('Are you sure?'); ?>');" class="btn btn-xs btn-danger"><i class="icon-remove"></i></button>    
                            </th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php if(count($estates)): foreach($estates as $estate):?>
                            <tr>
                                <td><?php echo $estate->id?></td>
                                <td>
                                <?php echo anchor('admin/estate/edit/'.$estate->id, _ch($estate->address) )?>
                                <?php if($estate->is_activated == 0):?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-danger"><?php echo lang_check('Not Activated')?></span>
                                <?php endif;?>
                                <?php if(isset($settings['listing_expiry_days']) && $settings['listing_expiry_days'] > 0 && strtotime($estate->date_modified) <= time()-$settings['listing_expiry_days']*86400): ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-warning"><?php echo lang_check('Expired'); ?></span>
                                <?php endif; ?>
                                <?php if(!empty($estate->activation_paid_date)):?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-success"><?php echo lang_check('Paid'); ?></span>
                                <?php endif; ?>
                                <?php if(!empty($estate->status)):?>
                                &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-info"><?php echo $estate->status; ?></span>
                                <?php endif; ?>
                                </td>
                                <td><?php echo check_set($available_agent[$this->estate_m->get_user_id($estate->id)], '')?></td>
                                <!-- Dynamic generated -->
                                <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                <td>
                                <?php
                                    echo $this->estate_m->get_field_from_listing($estate, $row->option_id);
                                ?>
                                </td>
                                <?php endforeach;?>
                                <!-- End dynamic generated -->
                                <td><?php echo $estate->counter_views; ?></td>
                                <td>
                                    <a class="btn btn-primary-blue" target="_blank" href="<?php echo site_url((config_item('listing_uri')===false?'property':config_item('listing_uri')).'/'.$estate->id);?>"><i class="icon-search"></i></a>

                                    <?php if(config_db_item('events_qr_confirmation') === TRUE): ?>
                                    <a href="<?php echo site_url('fproperties/events_qr/en/'.$estate->id.'/'); ?>" class="btn btn-success" target="_blank"><i class="icon-qrcode"></i> </a>
                                    <?php endif; ?>

                                </td>
                                <td><?php echo btn_edit_udora('admin/estate/edit/'.$estate->id)?></td>

                              <?php if(config_item('status_enabled') === TRUE && 
                                ($this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE' || 
                                 $this->session->userdata('type') == 'ADMIN'
                                )):?>


                                <td>
                                    <?php if(empty($estate->status) || $estate->status == 'REDUCED_PRICE' || $estate->status == 'RESUBMIT'): ?>
                                    <div class="btn-group">
                                    <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php echo lang_check('Status'); ?>
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <?php if($estate->status == 'RESUBMIT'): ?>
                                            <a href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE_RESUBMIT'); ?>">
                                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                                            <?php else: ?>
                                            <a href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE'); ?>">
                                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                        <?php if($estate->status == 'REDUCED_PRICE'): ?>
                                        <a class="" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/HOLD_REDUCED/statuses'); ?>">
                                        <i class="icon-pause"></i> <?php echo lang_check('On hold'); ?></a>
                                        <?php elseif($estate->status == 'RESUBMIT'): ?>
                                        <a class="" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/HOLD_RESUBMIT/statuses'); ?>">
                                        <i class="icon-pause"></i> <?php echo lang_check('On hold'); ?></a>
                                        <?php else: ?>
                                        <a class="" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/HOLD/statuses'); ?>">
                                        <i class="icon-pause"></i> <?php echo lang_check('On hold'); ?></a>
                                        <?php endif; ?>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/estate/status/'.$estate->id.'/DECLINE'); ?>">
                                            <i class="icon-remove-sign"></i> <?php echo lang_check('Decline'); ?></a>
                                        </li>
                                    </ul>
                                    <?php elseif($estate->status == 'HOLD' || $estate->status == 'HOLD_REDUCED'): ?>
                                    <div class="btn-group">
                                    <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php echo lang_check('Status'); ?>
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                        <?php if($estate->status == 'HOLD_REDUCED'): ?>
                                        <a class="" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE_REDUCED/statuses'); ?>">
                                        <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                                        <?php else: ?>
                                        <a class="" href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE/statuses'); ?>">
                                        <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                                        <?php endif;?> 
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/estate/status/'.$estate->id.'/CONTRACT'); ?>">
                                            <i class="icon-briefcase"></i> <?php echo lang_check('Contract property'); ?></a>
                                        </li>
                                    </ul>
                                    <?php elseif($estate->status == 'HOLD_ADMIN'): ?>
                                    <div class="btn-group">
                                    <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php echo lang_check('Status'); ?>
                                    <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('admin/estate/status/'.$estate->id.'/APPROVE'); ?>">
                                            <i class="icon-ok"></i> <?php echo lang_check('Approve'); ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('admin/estate/status/'.$estate->id.'/DECLINE'); ?>">
                                            <i class="icon-remove-sign"></i> <?php echo lang_check('Decline'); ?></a>
                                        </li>
                                    </ul>
                                    <?php endif;?> 
                                </td>
                             
                            
                            <?php elseif(check_acl('estate/delete')):?><td><?php echo btn_delete_udora('admin/estate/delete/'.$estate->id); ?></td>
                            <?php endif;?>
                                        

                                        
                                        <?php if(check_acl('estate/delete_multiple')):?>
                                            <td>
                                            <?php echo form_checkbox('delete_multiple[]', $estate->id, FALSE, 'class="flat checkbox-events"'); ?>
                                            </td>
                                        <?php endif;?>
                                    
                                    </tr>
                        <?php endforeach;?>
                        <?php else:?>
                                    <tr>
                                    	<td colspan="20"><?php echo lang('We could not find any');?></td>
                                    </tr>
                        <?php endif;?>           
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){
    $('.selcect_deselect_chackbox').click(function(e){
        e.preventDefault();
        
        if($(this).attr('data-status')=='checked'){
            $(this).attr('data-status','')
            $(".checkbox-events").prop('checked', false);
            $(".checkbox-events").parent().removeClass('checked');
        } else {
            $(".checkbox-events").prop('checked', true);
            $(".checkbox-events").parent().addClass('checked');
           $(this).attr('data-status','checked')
        }
    })
})

</script>
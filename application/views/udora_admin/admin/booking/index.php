<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Reservations')?></h3>
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
        <?php if($this->session->userdata('type') == 'ADMIN'): ?>
        <div class="row">
            <div class="col-md-12"> 
                <?php echo anchor('admin/booking/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add reservation'), 'class="btn btn-primary-blue"')?>
                
                <?php if(config_db_item('booking_multi_reservations') === TRUE): ?>
                <?php echo anchor('admin/booking/add_multiple', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add multiple reservations'), 'class="btn btn-primary-blue"')?>
                <?php endif; ?>
                
                <?php if(config_db_item('booking_import_enabled') === TRUE && ($this->session->userdata('type') == 'ADMIN' || $this->session->userdata('type') == 'AGENT_ADMIN')): ?>
                    <?php echo anchor('admin/booking/import_booked/', '<i class="icon-arrow-up"></i>&nbsp;&nbsp;'.lang_check('Import booked dates via XML'), 'class="btn btn-success pull-right"')?>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
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
                <form class="search-admin" action="<?php echo site_url($this->uri->uri_string()); ?>" method="GET" autocomplete="off" style="margin: 10px 0;">
                   <div class="row">
                    <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><?php echo lang_check('Client')?></label>
                        <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('smart_search_reservations'); ?>" type="text" />
                    </div>
                    </div>
                    <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label"><?php echo lang_check('Date from')?></label>
                            <div class="input-group date myDatepicker" id="myDatepicker1">
                                <input type="text" name="date_from" value="<?php echo set_value_GET('date_from', '', true); ?>"  placeholder="yyyy-MM-dd" data-format="yyyy-MM-dd" class="form-control">
                                <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-3">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label"><?php echo lang_check('Date to')?></label>
                            <div class="input-group date myDatepicker" id="myDatepicker2">
                                <input type="text" name="date_to" value="<?php echo set_value_GET('date_to', '', true); ?>"  placeholder="yyyy-MM-dd" data-format="yyyy-MM-dd" class="form-control">
                                <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" style="height: 17px;display: block;"></label>
                        <button type="submit" class="btn btn-default" style="padding: 8px 12px;"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>
                    </div>
                    </div>
                </div>
                </form>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <div class="padd-alert">
                    <?php echo validation_errors() ?>
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php echo $this->session->flashdata('message') ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                    <?php endif; ?>     
                </div>
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>#</th>
                            <th data-hide="phone,tablet"><?php echo lang_check('User');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Property');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('From Date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('To Date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Paid');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('booking/delete')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($reservations)): foreach($reservations as $listing):?>
                        <tr>
                        	<td><?php echo $listing->id?></td>
                            <td><a href="<?php echo site_url('admin/booking/edit/'.$listing->id); ?>"><?php echo '#'.$listing->user_id.' - '._ch($users[$listing->user_id])?></a>
                            <?php echo $listing->is_confirmed==1?'<i class="icon-ok"></i>':'<i class="icon-remove"></i>'; ?>
                            </td>
                            <td>
                            <a href="<?php echo site_url('admin/booking/index/'.$listing->property_id); ?>" class="label label-danger"><?php echo '#'.$listing->property_id.' - '._ch($properties[$listing->property_id])?></a>
                            </td>
                            <td>
                            <?php echo $listing->date_from?>
                            </td>
                            <td>
                            <?php echo $listing->date_to?>
                            </td>
                            <td>
                            <?php if($listing->total_paid == $listing->total_price): ?>
                            <span class="label label-success"><?php echo $listing->total_paid.'/'.$listing->total_price.' '.$listing->currency_code; ?></span>
                            <?php elseif($listing->total_paid > 0):?>
                            <span class="label label-warning"><?php echo $listing->total_paid.'/'.$listing->total_price.' '.$listing->currency_code; ?></span>
                            <?php else: ?>
                            <span class="label label-default"><?php echo $listing->total_paid.'/'.$listing->total_price.' '.$listing->currency_code; ?></span>
                            <?php endif; ?>
                            </td>
                        	<td><?php echo btn_edit_udora('admin/booking/edit/'.$listing->id)?></td>
                        	<?php if(check_acl('booking/delete')):?>
                            <td>
                            <?php if($listing->total_paid <= 0): ?>
                            <?php echo btn_delete_udora('admin/booking/delete/'.$listing->id)?>
                            <?php endif;?>
                            </td><?php endif;?>
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


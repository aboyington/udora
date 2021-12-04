<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Rates')?></h3>
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
        <?php echo anchor('admin/booking/edit_rate', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add rate'), 'class="btn btn-primary-blue"')?>
        <?php if(config_db_item('add_multiple_rates_summer_enabled') === TRUE ): ?>
            <?php echo anchor('admin/booking/add_multiple_rates_summer/', '<i class="icon-arrow-up"></i>&nbsp;&nbsp;'.lang_check('Add multiple rates (summer)'), 'class="btn btn-primary-blue"')?>
        <?php endif; ?>
        <?php if(config_db_item('booking_import_enabled') === TRUE && ($this->session->userdata('type') == 'ADMIN' || $this->session->userdata('type') == 'AGENT_ADMIN')): ?>
            <?php echo anchor('admin/booking/import_rate/', '<i class="icon-arrow-up"></i>&nbsp;&nbsp;'.lang_check('Import rates via XML'), 'class="btn btn-success pull-right"')?>
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
                <br/>
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
                            <th data-hide="phone,tablet"><?php echo lang_check('From Date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('To Date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Property');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                        	<?php if(check_acl('booking/delete_rate')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($rates)): foreach($rates as $news_post):?>
                            <tr>
                                <td><?php echo $news_post->id?></td>
                                <td>
                                <?php echo $news_post->date_from?>
                                </td>
                                <td>
                                <?php echo $news_post->date_to?>
                                </td>
                                <td>
                                <a href="<?php echo site_url('admin/booking/rates/'.$news_post->property_id); ?>" class="label label-danger"><?php echo '#'.$news_post->property_id.' - '.$properties[$news_post->property_id]?></a>
                                </td>
                                <td><?php echo btn_edit_udora('admin/booking/edit_rate/'.$news_post->id)?></td>
                                <?php if(check_acl('booking/delete_rate')):?><td><?php echo btn_delete_udora('admin/booking/delete_rate/'.$news_post->id)?></td><?php endif;?>
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


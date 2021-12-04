<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Visual templates editor')?></h3>
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

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('View all reviews')?></h2>
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
                <a class="btn btn-primary-blue" href="<?php echo site_url('admin/templates/edit'); ?>"><i class=" icon-plus"></i>&nbsp;&nbsp;<?php echo lang_check('Add page template'); ?></a>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang_check('Template name');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('templates/delete')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($listings)): foreach($listings as $listing_item):?>
                        <tr>
                            <td><?php echo $listing_item->id; ?></td>
                            <td>
                                <a href="<?php echo site_url('admin/templates/edit/'.$listing_item->id); ?>">
                                <?php echo $listing_item->template_name; ?>
                                </a>
                            </td>
                            <td><?php echo btn_edit_udora('admin/templates/edit/'.$listing_item->id)?></td>
                            <?php if(check_acl('templates/delete')):?><td><?php echo btn_delete_udora('admin/templates/delete/'.$listing_item->id)?></td><?php endif;?>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="20"><?php echo lang('We could not find any');?></td>
                        </tr>
                        <?php endif;?>                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('Listing templates')?></h2>
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
                 <a class="btn btn-primary-blue" href="<?php echo site_url('admin/templates/edit_listing'); ?>"><i class=" icon-plus"></i>&nbsp;&nbsp;<?php echo lang_check('Add listing template'); ?></a>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang_check('Template name');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('templates/delete_listing')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings_property)): foreach($listings_property as $listing_item):?>
                        <tr>
                            <td><?php echo $listing_item->id; ?></td>
                            <td>
                                <a href="<?php echo site_url('admin/templates/edit_listing/'.$listing_item->id); ?>">
                                <?php echo $listing_item->template_name; ?>
                                </a>
                            </td>
                            <td><?php echo btn_edit_udora('admin/templates/edit_listing/'.$listing_item->id)?></td>
                            <?php if(check_acl('templates/delete_listing')):?><td><?php echo btn_delete_udora('admin/templates/delete_listing/'.$listing_item->id)?></td><?php endif;?>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="20"><?php echo lang('We could not find any');?></td>
                        </tr>
                        <?php endif;?>                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('Result item templates')?></h2>
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
                <a class="btn btn-danger" href="<?php echo site_url('admin/templates/edit_item'); ?>"><i class=" icon-plus"></i>&nbsp;&nbsp;<?php echo lang_check('Add result item template'); ?></a>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang_check('Template name');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('templates/delete_item')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($listings_item)): foreach($listings_item as $listing_item):?>
                    <tr>
                        <td><?php echo $listing_item->id; ?></td>
                        <td>
                            <a href="<?php echo site_url('admin/templates/edit_item/'.$listing_item->id); ?>">
                            <?php echo $listing_item->template_name; ?>
                            </a>
                        </td>
                        <td><?php echo btn_edit_udora('admin/templates/edit_item/'.$listing_item->id)?></td>
                        <?php if(check_acl('templates/delete_item')):?><td><?php echo btn_delete_udora('admin/templates/delete_item/'.$listing_item->id)?></td><?php endif;?>
                    </tr>
                    <?php endforeach;?>
                    <?php else:?>
                    <tr>
                        <td colspan="20"><?php echo lang('We could not find any');?></td>
                    </tr>
                    <?php endif;?>                          
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
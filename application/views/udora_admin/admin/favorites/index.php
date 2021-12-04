<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Favorites')?></h3>
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
         <a class="btn btn-primary-blue pull-right" href="<?php echo site_url('cronjob/favorites/output'); ?>" target="_blank"><i class="icon-filter"></i>&nbsp;&nbsp;<?php echo lang_check('Test CronJob'); ?></a>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('View all favorites')?></h2>
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
                            <th><?php echo lang_check('Listing');?></th>
                            <th><?php echo lang_check('User');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Date');?></th>
                            <?php if(check_acl('favorites/delete')):?><th><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings)): foreach($listings as $listing_item):?>
                            <tr>
                                <td><?php echo $listing_item->id; ?></td>
                                <?php if(false): ?>
                                <td>
                                <?php 

                                $json_obj = json_decode($listing_item->json_object);

                                if(!empty($json_obj->field_10))
                                    echo $json_obj->field_10;

                                ?></td>
                                <?php endif; ?>

                                <td>
                                    <a href="<?php echo site_url('admin/favorites/index/'.$listing_item->property_id); ?>" class="label label-danger">
                                    <?php echo '#'.$listing_item->property_id.', '.$listing_item->address; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('admin/favorites/index/0/'.$listing_item->user_id); ?>" class="label label-warning">
                                    <?php echo $listing_item->username; ?>
                                    </a>
                                </td>
                                <td>
                                <?php echo $listing_item->date_saved; ?>
                                </td>
                                <?php if(check_acl('favorites/delete')):?><td><?php echo btn_delete_udora('admin/favorites/delete/'.$listing_item->id)?></td><?php endif;?>
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


<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Reviews')?></h3>
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
        <?php echo anchor('admin/reviews/allow_review', ''.lang_check('Allow review'), 'class="btn btn-primary-blue pull-right"')?>
    </div>
</div>
<!-- /Add page / events button -->


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
                            <th><?php echo lang_check('Listing');?></th>
                            <th><?php echo lang_check('User');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Stars');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Date');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('reviews/delete')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($listings)): foreach($listings as $listing_item):?>
                        <tr>
                            <?php 
                                /*<a href="<?php echo site_url('admin/booking/rates/'.$news_post->property_id); ?>" class="label label-danger"><?php echo '#'.$news_post->property_id.' - '.$properties[$news_post->property_id]?></a>
                            */ ?>
                            <td><?php echo $listing_item->id; ?></td>
                            <td>
                                <a href="<?php echo site_url('admin/reviews/index/'.$listing_item->listing_id); ?>" class="label label-danger">
                                <?php echo '#'.$listing_item->listing_id.', '.$listing_item->address; ?>
                                </a>
                            </td>
                            <td>
                            <?php if(!empty($listing_item->user_id)): ?>
                                <a href="<?php echo site_url('admin/reviews/index/0/'.$listing_item->user_id); ?>" class="label label-warning">
                                <?php echo $listing_item->username; ?>
                                </a>
                            <?php elseif(!empty($listing_item->user_mail)): ?>
                                <?php echo $listing_item->user_mail; ?>
                            <?php endif; ?>
                            </td>
                            <td><div class="review_stars_<?php echo $listing_item->stars; ?>"> </div></td>
                            <td>
                            <?php echo $listing_item->date_publish; ?>
                            </td>
                            <td><?php echo btn_edit_udora('admin/reviews/edit/'.$listing_item->id)?></td>
                            <?php if(check_acl('reviews/delete')):?><td><?php echo btn_delete_udora('admin/reviews/delete/'.$listing_item->id)?></td><?php endif;?>
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


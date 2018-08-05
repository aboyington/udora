<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Withdrawals')?></h3>
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
<?php echo anchor('admin/booking/withdrawals_export', '<i class="icon-arrow-down"></i>&nbsp;&nbsp;'.lang_check('Export not completed'), 'class="btn btn-info"')?>
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
                            <th><?php _l('User id');?></th>
                            <th data-hide="phone,tablet"><?php _l('Email');?></th>
                            <th data-hide="phone,tablet"><?php _l('Date requested');?></th>
                            <th data-hide="phone,tablet"><?php _l('Date completed');?></th>
                            <th><?php _l('Amount');?></th>
                            <th><?php _l('Completed');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('booking/delete_rate')):?><th data-hide="phone,tablet" class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($listings)): foreach($listings as $listing_item):?>
                            <tr>
                                <td><?php echo $listing_item->id_withdrawal?></td>
                                <td>
                                <a class="label label-danger" href="<?php echo site_url('admin/booking/withdrawals/'.$listing_item->user_id); ?>">
                                <?php echo '#'.$listing_item->user_id?>
                                </a>
                                </td>
                                <td>
                                <?php echo $listing_item->withdrawal_email?>
                                </td>
                                <td>
                                <?php echo $listing_item->date_requested?>
                                </td>
                                <td>
                                <?php echo $listing_item->date_completed?>
                                </td>
                                <td>
                                <?php echo $listing_item->amount.' '.$listing_item->currency?>
                                </td>
                                <td>
                                <?php 
                                if($listing_item->completed)
                                {
                                    echo '<span class="label label-success"><i class="icon-ok icon-white"></i></span>';
                                }
                                else
                                {
                                    echo '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
                                }
                                ?>
                                </td>
                                <td><?php echo btn_edit_udora('admin/booking/edit_withdrawal/'.$listing_item->id_withdrawal)?></td>
                                <td>
                                <?php

                                if(!$listing_item->completed)
                                    echo btn_delete_udora('admin/booking/delete_withdrawal/'.$listing_item->id_withdrawal);

                                ?>
                                </td>
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


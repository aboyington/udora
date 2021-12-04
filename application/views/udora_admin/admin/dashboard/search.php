<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Searching')?></h3>
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
                <h2><?php echo lang('Results of property searching')?></h2>
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
                            <th><?php echo lang('Address');?></th>
                            <!-- Dynamic generated -->
                            <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                            <th><?php echo $row->option?></th>
                            <?php endforeach;?>
                            <!-- End dynamic generated -->
                            <th class=""><?php echo lang('Edit');?></th>
                            <?php if(check_acl('estate/delete')):?><th class=""><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($estates)): foreach($estates as $estate):?>
                        <tr>
                            <td><?php echo $estate->id?></td>
                            <td><?php echo anchor('admin/estate/edit/'.$estate->id, $estate->address)?>
                            <?php if($estate->is_activated == 0):?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-danger"><?php echo lang_check('Not Activated')?></span>
                            <?php endif;?>
                            <?php if(isset($settings['listing_expiry_days']) && $settings['listing_expiry_days'] > 0 && strtotime($estate->date_modified) <= time()-$settings['listing_expiry_days']*86400): ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-warning"><?php echo lang_check('Expired'); ?></span>
                            <?php endif; ?>
                            <?php if(!empty($estate->activation_paid_date)):?>
                            &nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-success"><?php echo lang_check('Paid'); ?></span>
                            <?php endif; ?>
                            </td>
                            <!-- Dynamic generated -->
                            <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                            <td>
                            <?php
                                echo $this->estate_m->get_field_from_listing($estate, $row->option_id);
                            ?>
                            </td>
                            <?php endforeach;?>
                            <!-- End dynamic generated -->
                            <td><?php echo btn_edit_udora('admin/estate/edit/'.$estate->id)?></td>
                            <?php if(check_acl('estate/delete')):?><td><?php echo btn_delete_udora('admin/estate/delete/'.$estate->id)?></td><?php endif;?>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="8"><?php echo lang('We could not find any');?></td>
                            </tr>
                        <?php endif;?>              
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


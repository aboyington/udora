<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Enquire')?></h3>
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
         <?php echo anchor('admin/enquire/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang('Add a enquire'), 'class="btn btn-primary-blue"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Enquires')?></h2>
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
                      <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('smart_search_enquire'); ?>" type="text" />
                    </div>
                    <div class="form-group">
                   <input class="form-control" name="message" id="message" value="<?php echo set_value_GET('message', '', true); ?>" placeholder="<?php echo lang_check('Message part'); ?>" type="text" />
                    </div>
                    <div class="form-group">
                        <label for="readed_to"><?php echo form_checkbox('readed_to', 1,  set_value_GET('readed_to', '', true),'class="" id="readed_to"'); ?> <span style="margin-right: 10px;"> <?php echo lang_check('Unreaded'); ?></span> </label> 
                    </div>
                    <button type="submit" class="btn btn-default"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>
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
                <?php echo form_open('admin/enquire/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo lang('Date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Mail');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Message');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Estate');?></th>
                        	<th class=""><?php echo lang('Edit');?></th>
                        	<th class=""><?php echo lang('Delete');?></th>
                            <?php if(check_acl('enquire/delete_multiple')):?>
                            <th data-hide="phone">
                            <button type="submit" onclick="return confirm('<?php _l('Are you sure?'); ?>');" class="btn btn-xs btn-warning"><i class="icon-remove"></i></button>
                            </th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($enquires)): foreach($enquires as $enquire):?>
                                    <tr>
                                    	<td><?php echo anchor('admin/enquire/edit/'.$enquire->id, $enquire->date)?>&nbsp;&nbsp;<?php echo $enquire->readed == 0? '<span class="label label-warning">'.lang('Not readed').'</span>':''?></td>
                                        <td><?php echo $enquire->mail?></td>
                                        <td><?php echo word_limiter(strip_tags($enquire->message), 5);?></td>
                                        <td><?php 
                                        if(empty($enquire->property_id))
                                        	echo '-';
                                        else
                                        	echo '#'.$enquire->property_id.', '._ch($enquire->p_address);
                                        ?></td>
                                    	<td><?php echo btn_edit_udora('admin/enquire/edit/'.$enquire->id)?></td>
                                    	<td><?php echo btn_delete_udora('admin/enquire/delete/'.$enquire->id)?></td>
                                        <?php if(check_acl('enquire/delete_multiple')):?>
                                            <td>
                                            <?php echo form_checkbox('delete_multiple[]', $enquire->id, FALSE, 'class="flat"'); ?>
                                            </td>
                                        <?php endif;?>
                                    </tr>
                        <?php endforeach;?>
                        <?php else:?>
                                    <tr>
                                    	<td colspan="10"><?php echo lang('We could not find any messages')?></td>
                                    </tr>
                        <?php endif;?>            
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<?php if(count($maskings) && config_db_item('agent_masking_enabled') === TRUE): ?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Masking submissions')?></h2>
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
                <?php echo form_open('admin/estate/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php _l('Date');?></th>
                            <th data-hide="tablet"><?php _l('Name and surname');?></th>
                            <th data-hide="phone,tablet"><?php _l('Mail');?></th>
                            <th data-hide="phone,tablet"><?php _l('Phone');?></th>
                            <th data-hide="phone,tablet"><?php _l('Visitor type');?></th>
                            <th data-hide="phone,tablet"><?php _l('Allow contact');?></th>
                            <th data-hide="phone,tablet"><?php _l('Estate');?></th>
                            <th><?php echo lang('Delete');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($maskings)): foreach($maskings as $item):?>
                                    <tr>
                                    	<td><?php echo $item->date_submit; ?></td>
                                        <td><?php echo $item->name?></td>
                                        <td><?php if(!empty($item->email)): ?><a href="mailto:<?php echo $item->email?>"><?php echo $item->email?></a><?php endif; ?></td>
                                        <td><?php echo $item->phone?></td>
                                        <td><?php echo $item->visitor_type?></td>
                                        <td>
                                        <?php echo $item->allow_contact == 0? '<i class="icon-remove"></i>':'<i class="icon-ok"></i>'?>
                                        </td>
                                        <td><a target="_blank" href="<?php echo site_url((config_item('listing_uri')===false?'property':config_item('listing_uri')).'/'.$item->property_id); ?>"><?php echo '#'.$item->property_id; ?></a></td>
                                    	<td><?php echo btn_delete_udora('admin/enquire/delete_masking/'.$item->id)?></td>
                                    </tr>
                        <?php endforeach;?>
                        <?php else:?>
                                    <tr>
                                    	<td colspan="10"><?php echo lang('We could not find any messages')?></td>
                                    </tr>
                        <?php endif;?>             
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<?php endif;?>
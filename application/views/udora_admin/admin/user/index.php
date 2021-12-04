<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Users')?></h3>
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
<div class="clearfix"></div>

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
        <?php echo anchor('admin/user/edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang('Add a new user'), 'class="btn btn-primary-blue"')?>
        <?php echo anchor('admin/user/export', '<i class="icon-arrow-down"></i>&nbsp;&nbsp;'.lang('Export user list'), 'class="btn btn-default"')?>
        <?php if($this->session->userdata('type') == 'ADMIN' && config_db_item('user_custom_fields_enabled') === TRUE): ?>
            <?php echo anchor('admin/user/custom_fields/', '<i class="icon-list-alt"></i>&nbsp;&nbsp;'.lang_check('Custom fields'), 'class="btn btn-default pull-right"  style=""')?>
        <?php endif;?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('View all users')?></h2>
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
                    <input class="form-control" name="smart_search" id="smart_search" value="<?php echo set_value_GET('smart_search', '', true); ?>" placeholder="<?php echo lang_check('Smart agent search'); ?>" type="text" />
                  </div>
                  <div class="form-group">
                    <?php echo form_dropdown('type', array_merge(array(''=>lang_check('Type')),$this->user_m->user_types), set_value_GET('type', '', true), 'class="form-control"'); ?>
                  </div>
                  <button type="submit" class="btn btn-default"><i class="icon icon-search"></i>&nbsp;&nbsp;<?php echo lang_check('Search'); ?></button>

                </form>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <?php echo form_open('admin/user/delete_multiple', array('class' => '', 'style'=> 'padding:0px;margin:0px;', 'role'=>'form'))?> 
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo lang('Username');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Name and surname');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Type');?></th>
                            <?php if(config_item('agency_agent_enabled') == TRUE): ?>
                            <th data-hide="phone,tablet"><?php _l('Agency');?></th>
                            <?php endif;?>
                        	<th><?php echo lang('Edit');?></th>
                            <?php if($this->session->userdata('type') != 'AGENT_ADMIN'): ?>
                        	<th><?php echo lang('Delete');?></th>
                            <?php endif;?> 
                            <?php if(check_acl('user/delete_multiple')):?>
                            <th>
                            <button type="submit" onclick="return confirm('<?php _l('Are you sure?'); ?>');" class="btn btn-xs btn-danger flat"><i class="icon-remove"></i></button>
                            </th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($users)): foreach($users as $user):?>
                            <tr>
                                <td><?php echo anchor('admin/user/edit/'.$user->id, $user->username)?>&nbsp;&nbsp;<?php echo $user->activated == 0? '<span class="label label-warning"><i class="icon-remove"></i></span>':''?></td>
                                <td><?php echo $user->name_surname?></td>
                                <td>
                                    <span class="label label-<?php echo $this->user_m->user_type_color[$user->type]?>">
                                    <?php echo $this->user_m->user_types[$user->type]?>
                                    </span>
                                    <?php if(file_exists(APPPATH.'controllers/admin/expert.php')): ?>
                                    <?php echo (!empty($user->qa_id))?'&nbsp;<span class="label label-info">'.$expert_categories[$user->qa_id].'</span>':''; ?>
                                    <?php endif; ?>
                                </td>
                                <?php if(config_item('agency_agent_enabled') == TRUE): ?>
                                <td data-hide="phone,tablet"><?php 

                                $agency_title = $user->agency_name;

                                if(!empty($user->agency_custom_fields))
                                {
                                    $json_decoded = json_decode($user->agency_custom_fields);

                                    if(isset($json_decoded->cinput_4))
                                        $agency_title = $json_decoded->cinput_4;
                                }

                                echo $agency_title; 

                                ?></td>
                                <?php endif;?>

                                <td>
                                <?php if($this->session->userdata('type') == 'ADMIN'): ?>
                                   <?php echo btn_edit_udora('admin/user/edit/'.$user->id)?>
                                <?php elseif($this->session->userdata('type') == 'AGENT_ADMIN' && $user->type != 'ADMIN'): ?>
                                    <?php echo btn_edit_udora('admin/user/edit/'.$user->id)?>
                                <?php endif;?> 
                                </td>

                                <?php if($this->session->userdata('type') != 'AGENT_ADMIN'): ?>
                                <td><?php echo btn_delete_udora('admin/user/delete/'.$user->id)?></td>
                                <?php endif;?> 
                                <?php if(check_acl('user/delete_multiple')):?>
                                <td>
                                <?php echo form_checkbox('delete_multiple[]', $user->id, FALSE, ' id="check-all" class="flat"'); ?>
                                </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="3"><?php _l('We could not find any'); ?></td>
                            </tr>
                        <?php endif;?>    
                    </tbody>
                </table>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


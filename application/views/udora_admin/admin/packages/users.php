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


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('View all users')?></h2>
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
                            <th><?php echo lang_check('Username');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Package name');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Package expire date');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Days limit');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Listings limit');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Curr listings');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($users)): foreach($users as $listing):?>
                        <tr>
                        	<td><?php echo $listing->id; ?></td>
                            <td><a href="<?php echo site_url('admin/user/edit/'.$listing->id); ?>"><?php echo $listing->username; ?></a>
                            </td>
                            <td>
                            <?php echo $packages[$listing->package_id]; ?>
                            </td>
                            <td>
                            <?php 
                            if($packages_price[$listing->package_id] > 0)
                            if(strtotime($listing->package_last_payment) <= time() ||
                              (empty($listing->package_last_payment) && !empty($packages_days[$listing->package_id])) )
                            {
                                echo '<span class="label label-danger"><i class="icon-remove"></i>&nbsp;'.$listing->package_last_payment.'</span>';
                            }
                            else
                            {
                                echo $listing->package_last_payment; 
                            }
                            ?>
                            </td>
                            <td>
                            <?php echo $packages_days[$listing->package_id]; ?>
                            </td>
                            <td>
                            <?php echo $packages_listings[$listing->package_id]; ?>
                            </td>
                            <td>
                            <?php 
                            
                            if(isset($curr_listings[$listing->id]))
                            {
                                if($curr_listings[$listing->id] > $packages_listings[$listing->package_id])
                                {
                                    echo '<span class="label label-danger"><i class="icon-remove"></i>&nbsp;'.$curr_listings[$listing->id].'</span>';
                                }
                                else
                                {
                                    echo $curr_listings[$listing->id];
                                }
                            }
                            
                            ?>
                            </td>
                        	<td><?php echo btn_edit_udora('admin/user/edit/'.$listing->id); ?></td>
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


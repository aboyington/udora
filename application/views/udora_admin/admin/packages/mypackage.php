<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Packages')?></h3>
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
                <h2><?php echo lang_check('View all packages')?></h2>
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
                            <th data-hide="phone,tablet"><?php echo lang_check('Package name');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Price');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Days limit');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Listings limit');?></th>
                            <th data-hide="phone"><?php echo lang_check('Num featured limit');?></th>
                            <th class=""><?php echo lang('Buy/Extend');?></th>
                        </tr>
                    </thead>
                    <tbody>
<?php 
                            if(count($packages)): foreach($packages as $listing):
                            
                            if(!empty($user['package_id']) && 
                               $user['package_id'] != $listing->id &&
                               strtotime($user['package_last_payment']) >= time() &&
                               $packages_days[$listing->id] > 0 &&
                               $packages_price[$user['package_id']] > 0)
                            {
                                continue;
                            }
                            else if(!empty($listing->user_type) && $listing->user_type != 'AGENT' && $user['package_id'] != $listing->id)
                            {
                                continue;
                            }
                        ?>
                        <tr>
                        	<td><?php echo $listing->id; ?></td>
                            <td>
                                <?php echo $listing->package_name; ?>
                                <?php if(!empty($listing->user_type)): ?>
                                &nbsp;<span class="label label-danger"><?php echo $listing->user_type; ?></span>
                                <?php endif;?>  
                                <?php if($user['package_id'] == $listing->id):?>
                                &nbsp;<span class="label label-success"><?php echo lang_check('Activated'); ?></span>
                                <?php else: ?>
                                &nbsp;<span class="label label-important"><?php echo lang_check('Not activated'); ?></span>
                                <?php endif;?>
                                
                                <?php if($listing->package_price > 0 && $user['package_id'] == $listing->id && strtotime($user['package_last_payment']) < time() && $packages_days[$listing->id] > 0): ?>
                                &nbsp;<span class="label label-warning"><?php echo lang_check('Expired'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                            <?php echo $listing->package_price.' '.$listing->currency_code; ?>
                            </td>
                            <td>
                            <?php 
                                echo $listing->package_days;
                            
                                if($user['package_id'] == $listing->id && $listing->package_price > 0 &&
                                   strtotime($user['package_last_payment']) >= time() && $packages_days[$listing->id] > 0 )
                                {
                                    echo ', '.$user['package_last_payment'];
                                }
                            
                            ?>
                            </td>
                            <td>
                            <?php echo $listing->num_listing_limit; ?>
                            </td>
                            <td>
                            <?php echo $listing->num_featured_limit?>
                            </td>
                        	<td>
<?php if($listing->package_price > 0  && config_db_item('payments_enabled') == 1): ?>
<div class="btn-group">
<a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
<?php echo '<i class="icon-shopping-cart"></i> '.lang('Buy/Extend'); ?>
<span class="caret"></span>
</a>
<ul class="dropdown-menu">
    <?php if(!_empty(config_db_item('paypal_email'))): ?>
    <li><a href="<?php echo site_url('admin/packages/do_purchase_package/'.$listing->id.'/'.$listing->package_price); ?>"><?php echo lang_check('with PayPal'); ?></a></li>
    <?php endif; ?>
    
    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php') && config_db_item('authorize_api_login_id') !== FALSE): ?>
    <li><a href="<?php echo site_url('paymentconsole/authorize_payment/'.$this->language_m->db_languages_id[$content_language_id].'/'.$listing->package_price.'/'.$listing->currency_code.'/'.$listing->id.'/PAC'); ?>"><?php echo lang_check('with CreditCard'); ?></a></li>
    <?php endif; ?>
    
    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php') && !_empty(config_db_item('payu_api_pos_id'))): ?>
    <li><a href="<?php echo site_url('paymentconsole/payu_payment/'.$this->language_m->db_languages_id[$content_language_id].'/'.$listing->package_price.'/'.$listing->currency_code.'/'.$listing->id.'/PAC'); ?>"><?php echo lang_check('with CreditCard payu'); ?></a></li>
    <?php endif; ?>
    
    <?php if(!_empty(config_db_item('withdrawal_details')) && file_exists(APPPATH.'controllers/paymentconsole.php')):?>
    <li><a href="<?php echo site_url('paymentconsole/invoice_payment/'.$this->language_m->db_languages_id[$content_language_id].'/'.$listing->package_price.'/'.$listing->currency_code.'/'.$listing->id.'/PAC'); ?>"><?php echo lang_check('with bank payment'); ?></a></li>
    <?php endif; ?>
</ul>
<?php endif; ?>        
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


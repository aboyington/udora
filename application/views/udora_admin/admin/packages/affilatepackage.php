<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Affilate package')?></h3>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th data-hide="phone,tablet"><?php echo lang_check('County');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Price');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Days limit');?></th>
                            <th class=""><?php echo lang('Buy/Extend');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if(count($listings)): foreach($listings as $listing):
                            
                            if(! $listing->affilate_price > 0)
                            {
                                continue;
                            }
                        ?>
                        <tr>
                        	<td><?php echo $listing->id; ?></td>
                            <td>
                                <?php echo $listing->value; 
                                
                                $can_be_purchased = true;
                                
                                // If owner, show date expire
                                if(isset($affilate_users[$listing->id][$this->session->userdata('id')]))
                                {
                                    $item = $affilate_users[$listing->id][$this->session->userdata('id')];
                                    
                                    echo ' <span class="label label-warning">'.$item->date_expire.'</span>';
                                }
                                else if(isset($affilate_users[$listing->id]))
                                {
                                    $can_be_purchased = false;
                                }
                                
                                
                                ?>
                            </td>
                            <td>
                                <?php 
                                echo custom_number_format($listing->affilate_price*2).' ('.custom_number_format($listing->affilate_price).') '.$currency; 
                                
                                $payment_price = $listing->affilate_price*2;
                                if($can_be_purchased && isset($item) && strtotime($item->date_expire) > time())
                                {
                                    $payment_price = $listing->affilate_price;
                                }
                                
                                ?>
                            </td>
                            <td>
                                60 (30)
                            </td>
                            <td>
                            <?php if($listing->affilate_price > 0  && config_db_item('payments_enabled') == 1 && $can_be_purchased): ?>

                            <?php if($this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE'): ?>
                            <div class="btn-group">
                            <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo '<i class="icon-shopping-cart"></i> '.lang('Buy/Extend'); ?>
                            <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if(!_empty(config_db_item('paypal_email'))): ?>
                                <li><a href="<?php echo site_url('admin/packages/do_purchase_affilate/'.$listing->id.'/'.$payment_price); ?>"><?php echo lang_check('with PayPal'); ?></a></li>
                                <?php endif; ?>
                                <?php if(false): ?>
                                    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php') && config_db_item('authorize_api_login_id') !== FALSE): ?>
                                    <li><a href="<?php echo site_url('paymentconsole/authorize_payment/'.$this->language_m->db_languages_id[$content_language_id].'/'.$payment_price.'/'.$currency.'/'.$listing->id.'/AFF'); ?>"><?php echo lang_check('with CreditCard'); ?></a></li>
                                    <?php endif; ?>

                                    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php') && !_empty(config_db_item('payu_api_pos_id'))): ?>
                                    <li><a href="<?php echo site_url('paymentconsole/payu_payment/'.$this->language_m->db_languages_id[$content_language_id].'/'.$payment_price.'/'.$currency.'/'.$listing->id.'/AFF'); ?>"><?php echo lang_check('with CreditCard payu'); ?></a></li>
                                    <?php endif; ?>

                                    <?php if(!_empty(config_db_item('withdrawal_details')) && file_exists(APPPATH.'controllers/paymentconsole.php')):?>
                                    <li><a href="<?php echo site_url('paymentconsole/invoice_payment/'.$this->language_m->db_languages_id[$content_language_id].'/'.$payment_price.'/'.$currency.'/'.$listing->id.'/AFF'); ?>"><?php echo lang_check('with bank payment'); ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                            <?php else: ?>
                             <span class="label label-success"><?php _l('Available'); ?></span>
                            <?php endif; ?>


                            <?php elseif(!$can_be_purchased): ?>

                            <?php if($this->session->userdata('type') == 'ADMIN'): ?>
                             <a href="<?php echo site_url('admin/user/edit/'.key($affilate_users[$listing->id])); ?>"><span class="label label-warning"><?php _l('Already purchased'); ?></span></a>

                            <?php else: ?>
                             <span class="label label-warning"><?php _l('Already purchased'); ?></span>
                            <?php endif; ?>


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
            </div>
        </div>
    </div>
</div>


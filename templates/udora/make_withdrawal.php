<!DOCTYPE html>
<html>
<head>
    <?php _widget('head'); ?>
    <script src='assets/js/gmap3/gmap3.min.js'></script>
</head>
<body class="dashboard-body" id="main">
<?php _widget('header_menu'); ?>
<!-- Add Event -->
<div class="container dashboard-layout">
    <div class="raw">
        <div class="col-xs-12" style="padding-bottom: 30px;">
            <div class="col-md-3 hidden-xs hidden-sm pad0">
                <?php _widget('custom_loginusermenu');?>
            </div>
            <div class="col-xs-12 col-md-9 pad0">
                <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                    <div class="panel panel-default">
                        <div class="panel-heading">                                
                            <?php echo $page_title; ?>
                        </div>
                        <div class="panel-body left-align">
                            <div class="form-group" id="add-event">
                            <div class="widget-content widget-controls">
                                <span>
                                 <?php _l('You can withdraw up to:'); ?>
                                 <?php
                                     $index=0;
                                     $currencies = array(''=>'');

                                     if(count($withdrawal_amounts) == 0)echo '0';

                                     foreach($withdrawal_amounts as $currency=>$amount)
                                     {
                                         $currencies[$currency] = $currency;
                                         echo '<span class="label label-success">'.$amount.' '.$currency.'</span>&nbsp;';
                                     }
                                 ?>
                                </span>
                            </div>
                            <div class="widget-content widget-controls"> 
                                <?php echo validation_errors()?>
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
                            <div class="widget-content">
                               <?php echo form_open(current_url().'#form-block', array('class' => 'form-horizontal form-estate', 'role'=>'form'))?>                              
                                <div class="form-group control-group row">
                                  <label class="col-lg-2 control-label"><?php _l('Amount')?></label>
                                  <div class="controls">
                                  <div class="input-append">
                                    <?php echo form_input('amount', $this->input->post('amount') ? $this->input->post('amount') : '', 'class="form-control"'); ?>
                                  </div>
                                  </div>
                                </div>

                                <div class="form-group control-group row">
                                  <label class="col-lg-2 control-label"><?php _l('Currency code')?></label>
                                  <div class="controls">
                                    <?php echo form_dropdown('currency', $currencies, $this->input->post('currency') ? $this->input->post('currency') : '', 'class="form-control"')?>
                                  </div>
                                </div>

                                <div class="form-group control-group row">
                                  <label class="col-lg-2 control-label"><?php _l('Withdrawal email')?></label>
                                  <div class="controls">
                                  <div class="input-append">
                                    <?php echo form_input('withdrawal_email', $this->input->post('withdrawal_email') ? $this->input->post('withdrawal_email') : '', 'class="form-control"'); ?>
                                  </div>
                                  </div>
                                </div>

                                <div class="form-group control-group row">
                                  <div class="controls">
                                    <?php echo form_submit('submit', lang_check('Request withdrawal'), 'class="btn btn-action-accept"')?>
                                    <a href="<?php echo site_url('rates/payments/'.$lang_code)?>#content" class="btn btn-action-unaccept" type="button"><?php echo lang_check('Cancel')?></a>
                                  </div>
                                </div>
                            <?php echo form_close()?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php _widget('custom_footer'); ?>
<?php _widget('custom_javascript'); ?>
</body>
</html>

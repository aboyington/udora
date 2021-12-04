<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Invoice')?></h3>
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
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo empty($invoice->id_invoice) ? lang('Add Invoice') : lang('Edit Invoice').' "' . $invoice->id_invoice.'"'?></h2>
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
                <!-- Form starts.  -->
               <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Paid')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox($f_name = 'is_paid', '1', set_value($f_name, $invoice->$f_name), 'id="input_'.$f_name.'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Activated')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox($f_name = 'is_activated', '1', set_value($f_name, $invoice->$f_name), 'id="input_'.$f_name.'"')?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/monetize/invoices')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                        <?php
                            $data_json = json_decode($invoice->data_json);
                            $user = $data_json->user;
                            if(!empty($data_json->user->mail))
                            {
                                ?>
                                <a href="mailto:<?php echo $data_json->user->mail?>?subject=<?php echo lang_check('Reply on invoice')?>: <?php echo $invoice->invoice_num; ?>&amp;body=<?php echo $invoice->description?>" class="btn btn-success" target="_blank"><?php echo lang_check('Reply to email')?></a>
                                <?php 
                            }
                        ?>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('Invoice details')?></h2>
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
      <div class="row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6 text-right">
          <h1><?php _l('Invoice'); ?></h1>
          <h1><small><?php _l('Invoice'); ?> <?php echo $invoice->invoice_num; ?></small></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><?php _l('From'); ?>:</h4>
            </div>
            <div class="panel-body">
              <p>
                <?php echo $settings['address_footer']; ?> <br>
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-5 col-sm-offset-2 text-right">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4><?php _l('To'); ?>:</h4>
            </div>
            <div class="panel-body">
              <p>
                <strong><?php echo $user->company_name; ?></strong><br>
                <?php echo $user->address; ?> <br>
                <?php _l('ZIP / City')?>: <?php echo $user->zip_city; ?> <br>
                <?php _l('VAT number')?>: <?php echo $user->vat_number; ?> <br>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- / end client details section -->
      <table class="table table-bordered" style="border-top: 1px solid #DDD;border-left: 1px solid #DDD;">
        <thead>
          <tr>
            <th>
              <h4><?php _l('Item'); ?></h4>
            </th>
            <th>
              <h4><?php _l('Description'); ?></h4>
            </th>
            <th>
              <h4><?php _l('Qty'); ?></h4>
            </th>
            <th>
              <h4><?php _l('Price'); ?></h4>
            </th>
            <th>
              <h4><?php _l('Sub total'); ?></h4>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo  $invoice->reference_code. $invoice->reference_id; ?></td>
            <td><?php echo  $invoice->description; ?></td>
            <td class="text-right">1</td>
            <td class="text-right"><?php echo  $invoice->price.' '. $invoice->currency_code; ?></td>
            <td class="text-right"><?php echo  $invoice->price.' '. $invoice->currency_code; ?></td>
          </tr>
        </tbody>
      </table>
      <div class="row text-right">
        <div class="col-sm-2 col-sm-offset-8">
          <p>
            <strong>
            <?php _l('Total'); ?>: <br>
            </strong>
          </p>
        </div>
        <div class="col-sm-2">
          <strong>
          <?php echo $invoice->price.' '.$invoice->currency_code; ?>&nbsp;&nbsp;<br />
          </strong>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h4><?php _l('Bank payment details'); ?></h4>
            </div>
            <div class="panel-body">
              <?php echo $settings['withdrawal_details']; ?>
            </div>
          </div>
        </div>
        <div class="col-sm-7">

        </div>
      </div>
            </div>
        </div>
    </div>
</div>


<style>
    .table td.text-right{
        text-align: right;
    }
</style>
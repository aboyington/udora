<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Edit withdrawal'); ?></h3>
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
                <h2><?php echo lang_check('Withdrawal data')?></h2>
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
                      <label class="col-lg-2 control-label"><?php echo lang_check('User')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('user_id', $users, $item->user_id, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Amount')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('amount', set_value('amount', $item->amount), 'class="form-control" id="inputAmount" placeholder="'.lang_check('Amount').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Currency')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('currency', set_value('currency', $item->currency), 'class="form-control" id="inputCurrency" placeholder="'.lang_check('Currency').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Date requested')?></label>
                      <div class="col-lg-6">
                      <div class="input-group date myDatepicker_full" id="datetimepicker1">
                        <?php echo form_input('date_requested', set_value('date_requested', $item->date_requested), 'class="form-control" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Date completed')?></label>
                      <div class="col-lg-6">
                      <div class="input-group date myDatepicker_full" id="datetimepicker2">
                        <?php echo form_input('date_completed', set_value('date_completed', $item->date_completed), 'class="form-control" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Withdrawal email')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('withdrawal_email', set_value('withdrawal_email', $item->withdrawal_email), 'class="form-control" id="inputwithdrawal_email" placeholder="'.lang_check('Withdrawal email').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Completed')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('completed', '1', set_value('completed', $item->completed), 'id="inputCompleted"')?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/booking/withdrawals')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
               <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


<div class="page-title">
    <div class="title_left">
        <h3><?php echo empty($rate->id) ? lang_check('Add rate') : lang_check('Edit rate').' "' . $rate->id.'"'?></h3>
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
                <h2><?php echo lang_check('Rates data')?></h2>
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
                      <label class="col-lg-2 control-label"><?php echo lang_check('Property')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('property_id', $properties, $this->input->post('property_id') ? $this->input->post('property_id') : $rate->property_id, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('From date')?></label>
                      <div class="col-lg-6">
                      <div class="input-group date myDatepicker_full" id="datetimepicker1">
                        <?php echo form_input('date_from', $this->input->post('date_from') ? $this->input->post('date_from') : $rate->date_from, 'class="form-control" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('To date')?></label>
                      <div class="col-lg-6">
                      <div class="input-group date myDatepicker_full" id="datetimepicker2">
                        <?php echo form_input('date_to', $this->input->post('date_to') ? $this->input->post('date_to') : $rate->date_to, 'class="form-control" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                         <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Min stay')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('min_stay', set_value('min_stay', $rate->min_stay), 'class="form-control" id="inputMinStay" placeholder="'.lang('Min stay').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Changeover day')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('changeover_day', $changeover_days, set_value('changeover_day', $rate->changeover_day), 'class="form-control" id="inputChangeoverDay" placeholder="'.lang_check('Changeover day').'"')?>
                      </div>
                    </div>

                    <hr />
                    <h5><?php echo lang('Translation data')?></h5>
                   <div style="margin-bottom: 0px;" class="tabbable">
                      <ul class="nav nav-tabs">
                        <?php $i=0;foreach($this->showroom_m->languages as $key_lang=>$val_lang):$i++;?>
                        <li class="<?php echo $i==1?'active':''?>"><a data-toggle="tab" href="#<?php echo $key_lang?>"><?php echo $val_lang?></a></li>
                        <?php endforeach;?>
                      </ul>
                      <div style="padding-top: 25px;" class="tab-content">
                        <?php $i=0;foreach($this->showroom_m->languages as $key_lang=>$val_lang):$i++;?>
                        <div id="<?php echo $key_lang?>" class="tab-pane <?php echo $i==1?'active':''?>">
                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang('Rate nightly')?></label>
                              <div class="col-lg-10">
                                <?php echo form_input('rate_nightly_'.$key_lang, set_value('rate_nightly_'.$key_lang, $rate->{'rate_nightly_'.$key_lang}), 'class="form-control" id="inputRateNightly'.$key_lang.'" placeholder="'.lang('Rate nightly').'"')?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang_check('Rate weekly')?></label>
                              <div class="col-lg-10">
                                <?php echo form_input('rate_weekly_'.$key_lang, set_value('rate_weekly_'.$key_lang, $rate->{'rate_weekly_'.$key_lang}), 'class="form-control" id="inputRateWeekly'.$key_lang.'" placeholder="'.lang_check('Rate weekly').'"')?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang('Rate monthly')?></label>
                              <div class="col-lg-10">
                                <?php echo form_input('rate_monthly_'.$key_lang, set_value('rate_monthly_'.$key_lang, $rate->{'rate_monthly_'.$key_lang}), 'class="form-control" id="inputRateMonthly'.$key_lang.'" placeholder="'.lang('Rate monthly').'"')?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang('Currency code')?></label>
                              <div class="col-lg-10">
                                <?php 
                                // get all langauge data to fetch default paypal currency
                                $lang_data = $this->language_m->get($key_lang);

//                                            echo form_dropdown('currency_code_'.$key_lang, $currencies, 
//                                                               set_value('currency_code_'.$key_lang, $lang_data->currency_default), 
//                                                               'class="form-control" id="inputCurrencyCode'.$key_lang.'" placeholder="'.lang('Currency code').'"');

                                echo form_input('currency_code_'.$key_lang, set_value('currency_code_'.$key_lang, $lang_data->currency_default), 
                                                   'class="form-control" id="inputCurrencyCode'.$key_lang.'" placeholder="'.lang('Currency code').'" readonly');

                                ?>
                              </div>
                            </div>

                        </div>
                        <?php endforeach;?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/booking')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


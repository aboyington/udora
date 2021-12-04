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
                                    <?php echo form_dropdown('property_id', $properties, $this->input->post('property_id') ? $this->input->post('property_id') : '', 'class="form-control"')?>
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
                              
                                    <?php $lang_data = $this->language_m->get($key_lang);?>
                                        <table class="table-rates">
                                            <tr class="tabel-rates-header">
                                                <th><?php echo lang('Months');?></th>
                                                <th><?php echo lang('Rate weekly');?></th>
                                                <th><?php echo lang('Rate weekly');?></th>
                                                <th><?php echo lang('Rate weekly');?></th>
                                                <th><?php echo lang('Rate weekly');?></th>
                                                <th><?php echo lang('Rate weekly');?></th>
                                            </tr>
                                            
                                            <?php 
                                            for ($month=6;$month<=9;$month++) :
                                            ?>
                                            <tr>
                                                <td rowspan="2"><?php _che($months[$month]);?></td>
                                                <?php
                                                foreach ($cal_weeks[$month] as $week) {
                                                    echo '<td>'.date('d',$week[0]).'/'.date('d', ($week[count($week)-1]+86400)).'</td>';
                                                }
                                                ?>
                                                
                                                <?php if(count($cal_weeks[$month])<5):?>  
                                                    <td class="empty-td">
                                                    </td>
                                                <?php endif;?>
                                            </tr>
                                            <tr>
                                                <?php foreach ($cal_weeks[$month] as $key=>$week) : ?>
                                                    <td>
                                                        <?php echo form_input("rate_weekly_". $month."_".$key."_".$key_lang, set_value("rate_nightly_". $month."_".$key."_".$key_lang), 'class="table-rates-input perday"')?>
                                                        <?php echo $lang_data->currency_default;?>
                                                        <?php if($key_lang==1):?>  
                                                         <input class="table-rates-input perday" type="hidden" name="date_from_<?php echo $month;?>_<?php echo $key;?>" value="<?php echo date('Y-m-d 12:00:00', $week[0]);?>">
                                                        <input class="table-rates-input perday" type="hidden" name="date_to_<?php echo $month;?>_<?php echo $key;?>" value="<?php echo date('Y-m-d 12:00:00', $week[count($week)-1]+86400);?>">
                                                        <?php endif;?>
                                                    </td>
                                                <?php endforeach;?>
                                                <?php if(count($cal_weeks[$month])<5):?>  
                                                    <td class="empty-td">
                                                    </td>
                                                <?php endif;?>
                                            </tr>
                                            
                                            <?php endfor;?>
                                        </table>
                                        
                                    </div>
                                    <?php endforeach;?>
                                  </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-lg-10">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                                    <a href="<?php echo site_url('admin/booking/rates')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                                  </div>
                                </div>
                       <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
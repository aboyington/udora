<div class="page-title">
    <div class="title_left">
        <h3><?php echo empty($enquire->id) ? lang('Add a new enquire') : lang('Edit enquire').' "' . $enquire->name_surname.'"'?></h3>
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
                <h2><?php echo lang('Enquire data')?></h2>
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
                                  <label class="col-lg-2 control-label"><?php echo lang('Estate')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_dropdown_ajax('property_id', 'estate_m', set_value('property_id', $enquire->property_id), 'address', $content_language_id);?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php _l('Agent')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_dropdown_ajax('agent_id', 'user_m', set_value('agent_id', $enquire->agent_id), 'username');?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('Name and surname')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_input('name_surname', set_value('name_surname', $enquire->name_surname), 'class="form-control" id="inputNameSurname" placeholder="'.lang('Name and surname').'"')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('Phone')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_input('phone', set_value('phone', $enquire->phone), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('Mail')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_input('mail', set_value('mail', $enquire->mail), 'class="form-control" id="inputMail" placeholder="'.lang('Mail').'"')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('FromDate')?></label>
                                  <div class="col-lg-10">
                                  <div class="input-append" id="datetimepicker1">
                                    <?php echo form_input('fromdate', set_value('fromdate', $enquire->fromdate), 'class="picker" data-format="yyyy-MM-dd"')?>
                                    <span class="add-on">
                                      &nbsp;<i data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar">
                                      </i>
                                    </span>
                                  </div>
                                  </div>
                                </div>
                                
                                
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('ToDate')?></label>
                                  <div class="col-lg-10">
                                  <div class="input-append" id="datetimepicker2">
                                    <?php echo form_input('todate', set_value('todate', $enquire->todate), 'class="picker" data-format="yyyy-MM-dd"')?>
                                    <span class="add-on">
                                      &nbsp;<i data-date-icon="icon-calendar" data-time-icon="icon-time" class="icon-calendar">
                                      </i>
                                    </span>
                                  </div>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('Message')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_textarea('message', set_value('message', $enquire->message), 'placeholder="'.lang('Message').'" rows="3" class="form-control"')?>
                                  </div>
                                </div>    

                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('Address')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_textarea('address', set_value('address', $enquire->address), 'placeholder="'.lang('Address').'" rows="3" class="form-control"')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang('Readed')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_checkbox('readed', '1', set_value('readed', $enquire->readed), 'id="inputReaded"')?>
                                  </div>
                                </div>
                                
                                <hr />
                                <div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-10">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-success"')?>
                                    <a href="<?php echo site_url('admin/enquire')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                                    <?php if(isset($enquire->mail)):?>
                                    <a href="mailto:<?php echo $enquire->mail?>?subject=<?php echo lang('Reply on question for real estate')?>: <?php echo $enquire->p_address; ?>&amp;body=<?php echo $enquire->message?>" class="btn btn-primary-blue"><?php echo lang('Reply to email')?></a>
                                    <?php endif;?>
                                  </div>
                                </div>
                       <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


  <?php if($enquire->readed != 1 && config_item('quick_reply_enabled') === TRUE): ?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Quick reply')?></h2>
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
                <!-- Form starts.  -->
                <?php echo form_open('admin/enquire/reply/'.$enquire->id, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Reply message')?></label>
                      <div class="col-lg-10">
                        <?php echo form_textarea('last_reply', set_value('last_reply', $enquire->last_reply), 'placeholder="'.lang_check('Reply message').'" rows="3" class="form-control"')?>
                      </div>
                    </div>

                    <hr />
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang_check('Send message'), 'class="btn btn-success"')?>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>
 <?php endif; ?>


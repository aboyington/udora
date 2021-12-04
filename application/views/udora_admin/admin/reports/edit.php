<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Reported')?></h3>
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
                <h2><?php echo empty($report->id) ? lang('Add a new report') : lang('Edit report').' "' . $report->name.'"'?></h2>
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
                <?php echo validation_errors()?>
                <?php if($this->session->flashdata('message')):?>
                <?php echo $this->session->flashdata('message')?>
                <?php endif;?>
                <?php if($this->session->flashdata('error')):?>
                <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                <?php endif;?>
                <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Estate')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('property_id', $all_estates, set_value('property_id', $report->property_id), 'class="form-control"');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Agent')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('agent_id', $all_users, set_value('agent_id', $report->agent_id), 'class="form-control"');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Name and surname')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('name', set_value('name', $report->name), 'class="form-control" id="inputNameSurname" placeholder="'.lang('Name and surname').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Phone')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('phone', set_value('phone', $report->phone), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Mail')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('email', set_value('email', $report->email), 'class="form-control" id="inputMail" placeholder="'.lang('Mail').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Submit Date')?></label>
                      <div class="col-lg-6">
                      <div class="input-group date myDatepicker_full" id="datetimepicker1">
                        <?php echo form_input('date_submit', set_value('date_submit', $report->date_submit), 'class="form-control" data-format="yyyy-MM-dd"')?>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Message')?></label>
                      <div class="col-lg-10">
                        <?php echo form_textarea('message', set_value('message', $report->message), 'placeholder="'.lang('Message').'" rows="3" class="form-control"')?>
                      </div>
                    </div>    

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('allow_contact')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('allow_contact','1', set_value('allow_contact', $report->allow_contact), 'placeholder="'.lang('allow_contact').'" rows="3" class=""')?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/reports')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                        <?php if(isset($report->email)):?>
                        <a href="mailto:<?php echo $report->email?>?subject=<?php echo lang_check('Reply on report for real estate')?>: <?php echo $all_estates[$report->property_id]?>&amp;body=<?php echo $report->message?>" class="btn btn-success" target="_blank"><?php echo lang('Reply to email')?></a>
                        <?php endif;?>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

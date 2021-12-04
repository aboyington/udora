<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Settings')?></h3>
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
<div style="margin-bottom: 8px;" class="tabbable">
  <ul class="nav nav-tabs settings-tabs">
    <li class="active"><a href="<?php echo site_url('admin/settings/contact')?>"><?php echo lang('Company contact')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/language')?>"><?php echo lang('Languages')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/template')?>"><?php echo lang('Template')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/system')?>"><?php echo lang('System settings')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/addons')?>"><?php echo lang_check('Addons')?></a></li>
    <?php if(config_db_item('slug_enabled') === TRUE): ?>
    <li><a href="<?php echo site_url('admin/settings/slug')?>"><?php echo lang_check('SEO slugs')?></a></li>
    <?php endif; ?>
    <?php if(config_db_item('currency_conversions_enabled') === TRUE): ?>
    <li><a href="<?php echo site_url('admin/settings/currency_conversions')?>"><?php echo lang_check('Currency Conversions')?></a></li>
    <?php endif; ?>
  </ul>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Company data')?></h2>
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
                      <label class="col-lg-3 control-label"><?php echo lang('WebsiteTitle')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('websitetitle', set_value('websitetitle', isset($settings['websitetitle'])?$settings['websitetitle']:''), 'class="form-control" id="inputWebTitle" placeholder="'.lang('WebsiteTitle').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Address')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('address', set_value('address', isset($settings['address'])?$settings['address']:''), 'class="form-control" id="inputAddress" placeholder="'.lang('Address').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Gps')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('gps', set_value('gps', isset($settings['gps'])?$settings['gps']:''), 'class="form-control" id="inputGps" placeholder="'.lang('Gps').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label"><?php echo lang_check('Use as map center')?></label>
                      <div class="col-lg-9">
                          <?php echo form_checkbox('map_center', '1', set_value('map_center', isset($settings['map_center'])?$settings['map_center']:'0'), 'id="inputContactMapCenter"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('ContactMail')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('email', set_value('email', isset($settings['email'])?$settings['email']:''), 'class="form-control" id="inputContactMail" placeholder="'.lang('ContactMail').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang_check('Email alerts on new not actiated property')?></label>
                      <div class="col-lg-9">
                        <?php echo form_checkbox('email_alert', '1', set_value('email_alert', isset($settings['email_alert'])?$settings['email_alert']:'1'), 'id="inputContactMailAlert"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Phone')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('phone', set_value('phone', isset($settings['phone'])?$settings['phone']:''), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Fax')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('fax', set_value('fax', isset($settings['fax'])?$settings['fax']:''), 'class="form-control" id="inputPhone" placeholder="'.lang('Fax').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Address Footer')?></label>
                      <div class="col-lg-9">
                        <?php echo form_textarea('address_footer', set_value('address_footer', isset($settings['address_footer'])?$settings['address_footer']:''), 'placeholder="'.lang('Address Footer').'" rows="3" class="form-control"')?>
                      </div>
                    </div>

                    <div class="ln_solid"></div>

                    <div class="form-group">
                      <div class="col-lg-offset-3 col-lg-9">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/settings')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
    
    <div class="row">
    <div class="col-md-4">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Location')?></h2>
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
                    <div class="gmap" id="mapsAddress">
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
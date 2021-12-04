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
    <li><a href="<?php echo site_url('admin/settings/contact')?>"><?php echo lang('Company contact')?></a></li>
    <li class="active"><a href="<?php echo site_url('admin/settings/language')?>"><?php echo lang('Languages')?></a></li>
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
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Language')?></h2>
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
                <div class="padd-alert">
                    <?php echo validation_errors() ?>
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php echo $this->session->flashdata('message') ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                    <?php endif; ?>     
                </div>
                <div class="row">
                    <!-- Form starts.  -->
                   <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Language from lang file')?></label>
                      <div class="col-lg-2">
                        <?php echo form_input('language', set_value('language', $language->language), 
                                              'class="form-control" id="inputLanguage" placeholder="'.lang('Language').'"')?>
                      </div>
                      <div class="col-lg-8">
                        <?php echo $available_langs; ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Code')?></label>
                      <div class="col-lg-1">
                        <?php echo form_input('code', set_value('code', $language->code), 
                                              'class="form-control" id="inputCode" placeholder="'.lang('Code').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-2 control-label"><?php echo lang_check('Facebook lang code')?></label>
                      <div class="col-lg-1">
                        <?php echo form_input('facebook_lang_code', set_value('facebook_lang_code', $language->facebook_lang_code), 
                                              'class="form-control" id="inputCode" placeholder="'.lang_check('en_EN').'"')?>
                      </div>
                    </div>

                    <?php if(config_db_item('multi_domains_enabled') === TRUE): ?>
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Custom domain')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('domain', set_value('domain', $language->domain), 
                                              'class="form-control" id="input_domain" placeholder="'.lang_check('Custom domain').'"')?>
                      </div>
                    </div>
                    <?php endif;?>

                    <?php if(file_exists(APPPATH.'controllers/admin/booking.php')):?>
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Default PayPal currency code')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('currency_default', 
                                                 $currencies, set_value('currency_default', $language->currency_default), 'class="form-control"')?>
                      </div>
                    </div>
                    <?php endif;?>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Default')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('is_default', '1', set_value('is_default', $language->is_default), 'id="inputDefault"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Visible in menu')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('is_frontend', '1', set_value('is_frontend', $language->is_frontend), 'id="inputFrontend"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Is RTL')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('is_rtl', '1', set_value('is_rtl', $language->is_rtl), 'id="inputRtl"')?>

                        <?php 
                            if(config_db_item('is_rtl_supported') !== TRUE)
                            {
                                echo '<span class="badge badge-warning">';
                                _l('Not supported by selected template');
                                echo '</span>';
                            }

                        ?>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/settings/language')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>
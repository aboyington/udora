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
    <li><a href="<?php echo site_url('admin/settings/language')?>"><?php echo lang('Languages')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/template')?>"><?php echo lang('Template')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/system')?>"><?php echo lang('System settings')?></a></li>
    <li><a href="<?php echo site_url('admin/settings/addons')?>"><?php echo lang_check('Addons')?></a></li>
    <?php if(config_db_item('slug_enabled') === TRUE): ?>
    <li class="active"><a href="<?php echo site_url('admin/settings/slug')?>"><?php echo lang_check('SEO slugs')?></a></li>
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
                <h2><?php echo lang('SEO slug')?></h2>
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
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('SEO slug')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('slug', set_value('slug', $item->slug), 'class="form-control" id="inputSlug" placeholder="'.lang_check('SEO slug').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Real URL')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('real_url', set_value('real_url', $item->real_url), 'class="form-control" id="inputRealurl" placeholder="'.lang_check('Real URL').'"')?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/settings/slug')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                <?php echo form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>
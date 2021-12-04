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
    <li class="active"><a href="<?php echo site_url('admin/settings/template')?>"><?php echo lang('Template')?></a></li>
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
                <h2><?php echo lang('Template settings')?></h2>
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
                          <label class="col-lg-2 control-label"><?php echo lang('Template')?></label>
                          <div class="col-lg-10">
                              <div class="fluid-row">
                                <?php
                                  $templates_available[]='link';
                                ?>
                                <?php $key=0; foreach ($templates_available as $k => $value) : ?>

                                    <?php  //if($key==0)echo '<div class="row">';
                                    if($value=='link'):?>
                                    <div class = "col-sm-4 col-md-4 thumbnail-template">
                                        <label class="thumbnail-label" for="<?php _che($value);?>">
                                            <a href="<?php echo site_url("admin/settings/addons");?>"><div class = "thumbnail">
                                                <?php if(file_exists(FCPATH."adminudora-assets/img/templates.png")): ?>
                                                    <img src="<?php echo base_url("adminudora-assets/img/templates.png"); ?>" alt="">
                                                <?php else: ?>
                                                    <img src="<?php echo base_url("adminudora-assets/img/242x240.png"); ?>" alt="">
                                                <?php endif; ?>
                                                <div class = "caption">
                                                <span><?php _l("Find more");?></span>
                                                </div>
                                            </div>
                                          </a>
                                        </label>
                                    </div>
                                    <?php break; endif;?>
                                    <div class = "col-sm-4 col-md-4 thumbnail-template">
                                        <input name="template" value="<?php _che($value);?>" type="radio" id="<?php _che($value);?>" <?php echo ($settings['template']==$k) ? 'checked=checked': ''; ?>/>
                                        <label class="thumbnail-label" for="<?php _che($value);?>">
                                            <div class = "thumbnail">
                                                <?php if(file_exists(FCPATH."templates/".$value."/screenshot.png")): ?>
                                                    <img src="<?php echo base_url("templates/".$value."/screenshot.png"); ?>" alt="">
                                                <?php else: ?>
                                                    <img src="<?php echo base_url("adminudora-assets/img/242x240.png"); ?>" alt="">
                                                <?php endif; ?>
                                                <div class="thumbnail-badget">Selected</div>
                                                <div class = "caption">
                                                   <span><?php _che(ucfirst($value));?></span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <?php
                                    /*if( ($key+1)%3==0 )
                                    {
                                        echo '</div><div class="row">';
                                    }
                                    if( ($key+1)==(count($templates_available)+1) ) echo '</div>';
                                    $key++;*/
                                     ?>
                                <?php endforeach; ?>
                              </div>
                          </div>
                        </div>

                        <?php upload_field_admin('website_logo', 'Website logo', 2, $settings['website_logo']); ?>

                        <?php if(config_item('secondary_logo_support') == TRUE):?> 
                        <?php upload_field_admin('website_logo_secondary', 'Website logo secondary', 2, $settings['website_logo_secondary']); ?>
                        <?php endif; ?>

                        <?php upload_field_admin('website_favicon', 'Website Favicon', 2, $settings['website_favicon']); ?>

                        <?php upload_field_admin('watermark_img', 'Watermark', 2, $settings['watermark_img'], lang_check('Watermark will be added to new uploaded images only')); ?> 

                        <?php upload_field_admin('search_background', 'Search form background', 2, $settings['search_background']); ?>

                        <?php if(config_item('template_colors_enabled') === TRUE): ?>
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php _l('Default template color')?></label>
                          <div class="col-lg-10">
                            <?php echo form_dropdown('color', $colors_available, set_value('color', isset($settings['color'])?$settings['color']:''), 'class="form-control"')?>
                          </div>
                        </div>
                        <?php endif; ?>

                        <?php if(config_item('visual_templates_enabled') === TRUE): ?>
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php _l('Visual templates editor')?></label>
                          <div class="col-lg-10">
                            <a href="<?php echo site_url('admin/templates/index'); ?>" class="btn btn-primary-blue"><?php _l('Manage templates')?></a>
                          </div>
                        </div>
                        <?php endif; ?>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php _l('Files editor')?></label>
                          <div class="col-lg-10">
                            <a href="<?php echo site_url('admin/templatefiles/index'); ?>" class="btn btn-default"><?php _l('Template files list')?></a>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php _l('Email templates editor')?></label>
                          <div class="col-lg-10">
                            <a href="<?php echo site_url('admin/emailfiles/index'); ?>" class="btn btn-default"><?php _l('Template files list')?></a>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang('Tracking')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('tracking', set_value('tracking', isset($settings['tracking'])?$settings['tracking']:''), 'placeholder="'.lang('Tracking').'" rows="3" class="form-control"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Facebook or Social code')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('facebook', set_value('facebook', isset($settings['facebook'])?$settings['facebook']:''), 'placeholder="'.lang('Facebook').'" rows="3" class="form-control"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Facebook or Social code on Top')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('facebook_top', set_value('facebook_top', isset($settings['facebook_top'])?$settings['facebook_top']:''), 'placeholder="'.lang_check('Facebook or Social code on Top').'" rows="3" class="form-control"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Facebook Javascript SDK code')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('facebook_jsdk', set_value('facebook_jsdk', isset($settings['facebook_jsdk'])?$settings['facebook_jsdk']:''), 'placeholder="'.lang('Facebook Javascript SDK code').'" rows="3" class="form-control"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Facebook comments code')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('facebook_comments', set_value('facebook_comments', isset($settings['facebook_comments'])?$settings['facebook_comments']:''), 'placeholder="'.lang('Facebook comments code').'" rows="3" class="form-control"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Useful links')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('useful_links', set_value('useful_links', isset($settings['useful_links'])?$settings['useful_links']:''), 'placeholder="'.lang('Useful links').'" rows="3" class="form-control"')?>
                          </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                            <a href="<?php echo site_url('admin/settings')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                          </div>
                        </div>
                    <?php echo form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>
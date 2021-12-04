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
<!-- Add page / events button -->
<div class="x_panel">
    <div class="x_title">
        <h2><?php echo lang_check('Quick Add');?></h2>
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
        <?php echo '<a href="?translate=mymemory" class="btn btn-primary-blue"><i class="icon-share"></i>&nbsp;&nbsp;'.lang_check('Translate with MyMemory API').'</a>'; ?>
        <?php echo '<a href="?translate=google" class="btn btn-primary-blue"><i class="icon-share"></i>&nbsp;&nbsp;'.lang_check('Translate with Google API').'</a>'; ?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Language').': '.$lang_name.', '.lang('File').': '.$file?></h2>
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
                 <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>     
                    <?php foreach($language_translations_english as $key=>$value):?>
                        <div class="form-group <?php echo (!empty($value) && empty($language_translations_current[$key]))?'has-error':''; ?>">
                          <label class="col-lg-4 control-label control-label-right"><?php echo $value; ?></label>
                          <div class="col-lg-7">
                            <?php 

                            $translated_value = '';

                            if(!empty($language_translations_current[$key]) && $language_translations_current[$key] != $value)
                            {
                                $translated_value = $language_translations_current[$key];
                            }
                            elseif(!empty($value) && isset($this->mymemorytranslation) ||
                                   $language_translations_current[$key] == $value && isset($this->mymemorytranslation) && !empty($value))
                            {
                                if(isset($_GET['translate']) && $_GET['translate'] == 'mymemory')
                                {
                                    $translated_value = $this->mymemorytranslation->translate($value, 'en', $lang_code);
                                }
                                else if(isset($_GET['translate']) && $_GET['translate'] == 'google')
                                {
                                    $translated_value = $this->gtranslation->translate($value, 'en', $lang_code);
                                }
                                else if(!empty($language_translations_current[$key]))
                                {
                                    $translated_value = $language_translations_current[$key];
                                }                                    
                            }
                            else
                            {

                            }

                            echo form_input(md5($key), set_value(md5($key), $translated_value), 'class="form-control" id="inputAddress" placeholder="'.$value.'"')?>
                          </div>
                          <div class="col-lg-1">
                          <a target="_blank" href="https://translate.google.com/#en/<?php echo $lang_code.'/'.$value; ?>"><i class="icon-share"></i></a>
                          </div>
                        </div>
                    <?php endforeach;?>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-4 col-lg-8">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/settings/language_files/'.$lang_id)?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                    <?php echo form_close()?>
                </table>
            </div>
        </div>
    </div>
</div>


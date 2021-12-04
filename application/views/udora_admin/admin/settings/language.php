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
         <?php echo anchor('admin/settings/language_edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add language'), 'class="btn btn-primary-blue"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Website language')?></h2>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo lang('Language');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Code');?></th>
                            <th data-hide="phone,tablet"><?php echo lang('Default');?></th>
                            <th data-hide="phone,tablet"><?php echo lang_check('Translate files');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <th class=""><?php echo lang('Delete');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($languages)): foreach($languages as $language):?>
                        <tr>
                            <td>
                                <?php echo anchor('admin/settings/language_edit/'.$language->id, lang_check($language->language))?>
                                <?php echo ($language->is_locked == 1)?'&nbsp;&nbsp;<i class="icon-lock"></i>':''?>
                                <?php echo ($language->is_frontend == 0)?'&nbsp;&nbsp;<i class="icon-eye-close"></i>':''?>
                            </td>
                            <td><?php echo $language->code?></td>
                            <td><?php echo ($language->is_default == 1)?'<i class="icon-ok"></i>':''?></td>
                            <td style="width: 100px;text-align:center;"><a href="<?php echo site_url('admin/settings/language_files/'.$language->id)?>" class="btn btn-info"><i class="icon-list"></i>&nbsp;<?php echo lang_check('Translate files'); ?></a></td>
                            <td><?php echo btn_edit_udora('admin/settings/language_edit/'.$language->id)?></td>
                            <td><?php echo btn_delete_udora('admin/settings/language_delete/'.$language->id)?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="6"><?php echo lang('We could not find any languages')?></td>
                        </tr>
                        <?php endif;?>                               
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


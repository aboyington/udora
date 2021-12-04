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
    <li><a href="<?php echo site_url('admin/settings/slug')?>"><?php echo lang_check('SEO slugs')?></a></li>
    <?php endif; ?>
    <?php if(config_db_item('currency_conversions_enabled') === TRUE): ?>
    <li class="active"><a href="<?php echo site_url('admin/settings/currency_conversions')?>"><?php echo lang_check('Currency Conversions')?></a></li>
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
        <?php echo anchor('admin/settings/currency_conversions_edit', '<i class="icon-plus"></i>&nbsp;&nbsp;'.lang_check('Add currency'), 'class="btn btn-primary-blue"')?>
        <?php echo anchor('admin/settings/currency_import_from_ecb/', '<i class="icon-arrow-up"></i>&nbsp;&nbsp;'.lang_check('Import from XML'), 'class="btn btn-success pull-right"')?>
    </div>
</div>
<!-- /Add page / events button -->


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Currency Conversions')?></h2>
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
                   <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>
                    
                    <?php if($language_writing_permissions != ''):?>
                    <p class="label label-important validation"><?php echo $language_writing_permissions;?></p>
                    <?php endif; ?>   
                </div>
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                       <tr>
                            <th><?php echo lang_check('Currency code');?></th>
                            <th><?php echo lang_check('Conversion index');?></th>
                            <th><?php echo lang_check('Currency symbol');?></th>
                            <th class=""><?php echo lang('Edit');?></th>
                            <th class=""><?php echo lang('Delete');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($conversions)): foreach($conversions as $item):?>
                        <tr>
                            <td>
                                <?php echo anchor('admin/settings/currency_conversions_edit/'.$item->id, lang_check($item->currency_code))?>
                            </td>
                            <td><?php echo $item->conversion_index?></td>
                            <td><?php echo $item->currency_symbol?></td>
                            <td><?php echo btn_edit_udora('admin/settings/currency_conversions_edit/'.$item->id)?></td>
                            <td><?php echo btn_delete_udora('admin/settings/currency_conversions_delete/'.$item->id)?></td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                        <tr>
                            <td colspan="6"><?php echo lang('We could not find any')?></td>
                        </tr>
                        <?php endif;?>                              
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


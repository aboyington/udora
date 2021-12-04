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
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Rates data')?></h2>
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
                    <?php echo validation_errors()?>
                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error'); ?></p>
                    <?php endif;?>
                    <?php if(!empty($error)):?>
                    <p class="label label-important validation"> <?php echo $error; ?> </p>
                    <?php endif;?>   
                </div>
                <div class="row">
                    <!-- Form starts.  -->
                  <?php echo form_open_multipart(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('XML Url')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('xml_url', $this->input->post('xml_url') ? $this->input->post('xml_url') : 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml', 'class="form-control" id="inputMinStay" placeholder="'.lang('XML Url').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('XML File')?></label>
                      <div class="col-lg-10">
                        <input id="userfile_xml" type="file" name="userfile_xml" size="20" />
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang_check('Import'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/settings/currency_conversions')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                    
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Default Currency')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('currencies_default', $currencies, $this->input->post('currencies_default') ? $this->input->post('currencies_default') : $currencies_default_id, 
                                                 'class="form-control"')?>
                      </div>
                    </div>
                    <?php echo form_close()?>
                </div>
                <div class="widget-foot">
                    <?php if(!empty($import_end)): ?>
                    <p><?php _l('Update completed'); ?>:</p>
                    <table class="table table-striped">
                    <tr>
                    <th>#</th>
                    <th><?php _l('Update'); ?></th>
                    </tr>
                    <?php foreach($imports as $property_id=>$property_imports): ?>
                    <tr>
                    <td><?php echo $property_id; ?></td>
                    <td><?php echo $property_imports; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                                        <p><?php _l('Example XML file'); ?>:</p>
                                        <pre>
                    <?php echo htmlentities('<gesmes:Envelope xmlns:gesmes="http://www.gesmes.org/xml/2002-08-01" xmlns="http://www.ecb.int/vocabulary/2002-08-01/eurofxref">
                        <gesmes:subject>Reference rates</gesmes:subject>
                        <gesmes:Sender>
                            <gesmes:name>European Central Bank</gesmes:name>
                        </gesmes:Sender>
                        <Cube>
                            <Cube time="2016-01-04">
                                <Cube currency="USD" rate="1.0898"/>
                                <Cube currency="JPY" rate="129.78"/>
                                <Cube currency="BGN" rate="1.9558"/>
                                <Cube currency="CZK" rate="27.023"/>
                                <Cube currency="DKK" rate="7.4620"/>
                                <Cube currency="GBP" rate="0.73810"/>
                                <Cube currency="HUF" rate="315.39"/>
                            </Cube>
                        </Cube>
                    </gesmes:Envelope>');
                    ?>
                                        </pre>

                    <p><?php _l('Example XML Url'); ?>:</p>
                    <pre>
                    <?php echo htmlentities('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
                    ?>
                                        </pre>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
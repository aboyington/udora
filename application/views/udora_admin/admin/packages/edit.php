<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Packages')?></h3>
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
                <h2><?php echo empty($package->id) ? lang_check('Add package') : lang_check('Edit package').' "' . $package->id.'"'?></h2>
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
                      <label class="col-lg-2 control-label"><?php echo lang('Package name')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('package_name', set_value('package_name', $package->package_name), 'class="form-control" id="inputPackageName" placeholder="'.lang('Package name').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Package price')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('package_price', set_value('package_price', $package->package_price), 'class="form-control" id="inputPackagePrice" placeholder="'.lang('Package price').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Currency code')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('currency_code', $currencies, $this->input->post('currency_code') ? $this->input->post('currency_code') : $package->currency_code, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Num listing limit')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('num_listing_limit', set_value('num_listing_limit', $package->num_listing_limit), 'class="form-control" id="input_num_listing_limit" placeholder="'.lang('Num listing limit').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Days limit')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('package_days', set_value('package_days', $package->package_days), 'class="form-control" id="input_package_days" placeholder="'.lang('Days limit').'"')?>
                      </div>
                    </div>

                    <?php if(config_item('enable_num_images_listing')): ?>
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Num images limit')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('num_images_limit', set_value('num_images_limit', $package->num_images_limit), 'class="form-control" id="input_num_images_limit" placeholder="'.lang_check('Num images limit').'"')?>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php if(config_item('enable_num_amenities_listing')): ?>
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Num amenities limit')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('num_amenities_limit', set_value('num_amenities_limit', $package->num_amenities_limit), 'class="form-control" id="input_num_amenities_limit" placeholder="'.lang_check('Num amenities limit').'"')?>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php if(config_db_item('enable_num_featured_limit')): ?>
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Num featured limit')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('num_featured_limit', set_value('num_featured_limit', $package->num_featured_limit), 'class="form-control" id="input_num_featured_limit" placeholder="'.lang_check('Num featured limit').'"')?>
                      </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Show private listings')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('show_private_listings', '1', set_value('show_private_listings', $package->show_private_listings), 'id="input_show_private_listings"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Auto activate properties')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('auto_activation', '1', set_value('auto_activation', $package->auto_activation), 'id="input_auto_activation"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('User type')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('user_type', array(''=>'','AGENT'=>'AGENT','USER'=>'USER'), $this->input->post('user_type') ? $this->input->post('user_type') : $package->user_type, 'class="form-control"')?>
                      </div>
                    </div>

                   <div class="ln_solid"></div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/packages')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

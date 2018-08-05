<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Google Places import')?></h3>
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
                <h2><?php echo lang('Import data')?></h2>
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
                    <?php if(!empty($message)):?>
                    <p class="label label-important validation"> <?php echo $message; ?> </p>
                    <?php endif;?>
                </div>
                <!-- Form starts.  -->
                    <?php echo form_open_multipart(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Gps')?></label>
                          <div class="col-lg-10">
                            <?php echo form_input('gps_google', $this->input->post('gps_google') ? $this->input->post('gps_google') : $gps, 'class="form-control" id="inputMinStay" placeholder="-33.8670,151.1957"')?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Radius')?> (m)</label>
                          <div class="col-lg-10">
                            <?php echo form_input('radius', $this->input->post('radius') ? $this->input->post('radius') : '500', 'class="form-control" id="inputRadisu" placeholder="500"')?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Types')?></label>
                          <div class="col-lg-10">
                                <?php echo form_dropdown('type', array_merge(array(''=>'Select type'),$types_list), $this->input->post('type'), 'class="form-control ui-state-valid"');?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Name')?></label>
                          <div class="col-lg-10">
                            <?php echo form_input('name', $this->input->post('name') ? $this->input->post('name') : '', 'class="form-control" id="inputRadisu" placeholder="Cruise"')?>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Language')?></label>
                          <div class="col-lg-10">
                            <?php echo form_dropdown('lang_api', array_merge(array(''=>'Select lang'),$langs_api), $this->input->post('lang_api') ? $this->input->post('lang_api') : $lang_code, 'class="form-control" id="inputLang" placeholder="Lang"')?>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputGeocode_api"><?php echo lang_check('Use Geocode Api (address, city, country)')?></label>
                            <div class="col-lg-10">
                                <?php echo form_checkbox('geocode_api', 1, $this->input->post('geocode_api') ? $this->input->post('geocode_api') : false, 'id="inputGeocode_api"')?>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <?php echo form_submit('submit', lang_check('Preview'), 'class="btn btn-primary-blue"')?>
                            <a href="<?php echo site_url('admin/estate/')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                          </div>
                        </div>
                    <?php echo form_close()?>
            </div>
            <div class="clearfix"></div>
            <div class="widget-foot">
                <?php if(!empty($preview_data)&&$imported!==TRUE): ?>
                <p><?php  _l('Preview'); ?>:</p>
                <?php echo form_open_multipart(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                 
                <table class="table table-striped">
                <tr>
                <th><?php _l('#'); ?></th>
                <th><?php _l('Title'); ?></th>
                <th><?php _l('Address'); ?></th>
                <th><?php _l('Gps'); ?></th>
                <th><a href="#" id='selcect_deselect_chackbox' data-status='' class="btn btn-danger" type="button"><i class="icon-check"></i></a></th>
                </tr>
                <?php foreach($preview_data as $key=>$item): ?>
                <tr class="<?php echo (isset( $item['exists'])&&!empty($item['exists']))?'tr-red': '';?>" >

                <td><?php echo ++$key; ?></td>
                <td class='tr-title'><?php echo $item['name']; ?></td>
                <td><?php echo $item['address']; ?></td>
                <td><a href="http://www.google.com/maps/place/<?php echo urlencode($item['gps']); ?>" target="_blunk"><?php echo $item['gps']; ?></a></td>
                <td>
                    <?php if(/*!isset( $item['exists']) || empty($item['exists'])*/ TRUE): ?>
                    <input type="checkbox" name="add_multiple[]" class='check-box-places' value="<?php echo $item['id'];?>" checked="checked">
                    <?php endif;?>
                </td>
                </tr>
                <?php endforeach; ?>
                </table>
            </div>
            <div class="widget-content">
    <div class="padd clearfix">
    <div class="form-group clearfix">
      <label class="col-lg-2 control-label"><?php echo lang_check('Choose category for import')?></label>
      <div class="col-lg-10">
            <?php echo form_dropdown('type_db', array_merge(array(''=>'Select category'),$category_list), $this->input->post('type_db'), 'class="form-control ui-state-valid"');?>
      </div>
    </div>     
    <div class="form-group clearfix">
      <label class="col-lg-2 control-label"><?php echo lang_check('Choose marker for import')?></label>
      <div class="col-lg-10">
            <?php echo form_dropdown('marker_category', array_merge(array(''=>'Select marker'),$marker_list), $this->input->post('marker_category'), 'class="form-control ui-state-valid"');?>
      </div>
    </div>     
    <div class="form-group clearfix">
    <label class="col-lg-2 control-label"><?php echo lang_check('Max images per property')?></label>
        <div class="col-lg-10">
            <?php echo form_input('max_images', $this->input->post('max_images') ? $this->input->post('max_images') : '1', 'class="form-control ui-state-valid"');?>
        </div>
    </div>                  
    <div class="form-group clearfix">
      <div class="col-lg-offset-2 col-lg-10">
        <?php echo form_submit('submit', lang_check('Import'), 'class="btn btn-primary-blue" onclick="return confirm(\' All selected places will be import\')"')?>
        <a href="<?php echo site_url('admin/estate/')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
      </div>
    </div>
        <input type="hidden" name="form_import" value='1' />
        <input type="hidden" name="gps_google" value='<?php echo $gps_google;?>' />
        <input type="hidden" name="type" value='<?php echo $type;?>' />
        <input type="hidden" name="radius" value='<?php echo $radius;?>' />
        <input type="hidden" name="name" value='<?php echo $name;?>' />
        <input type="hidden" name="lang_api" value='<?php echo $lang_api;?>' />
        <input type="hidden" id="inputGeocode_api_secondary" name="geocode_api" value='<?php echo $geocode_api;?>' />
        <input type="hidden" name="cache_results" value='<?php echo $cache_results;?>' />
<?php echo form_close()?>
</div> </div>
  <?php elseif($imported==TRUE&&!empty($preview_data)): ?>
    <p><?php  _l('Added/updated location'); ?>:</p>
    <table class="table table-striped">
    <tr>
    <th><?php _l('#'); ?></th>
    <th><?php _l('Title'); ?></th>
    <th><?php _l('Address'); ?></th>
    <th><?php _l('Gps'); ?></th>
    </tr>
    <?php foreach($preview_data as $key=>$item): ?>
    <tr>
    <td><?php echo ++$key; ?></td>
    <td> <a href="<?php echo site_url('admin/estate/edit/'.$item['preview_id']); ?>"><?php echo $item['name']; ?></a></td>
    <td><?php echo $item['address']; ?></td>
    <td><?php echo $item['gps']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
     </div>         
<?php endif; ?>
                            
            
            
        </div>
        </div>
    </div>
</div>



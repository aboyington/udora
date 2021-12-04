<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Import Xml')?></h3>
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
                          <label class="col-lg-2 control-label"><?php echo lang('XML Url')?></label>
                          <div class="col-lg-10">
                            <?php echo form_input('xml_url', $this->input->post('xml_url'), 'class="form-control" id="inputMinStay" placeholder="'.lang('XML Url').'"')?>
                          </div>
                        </div>
                        <div class="form-group clearfix">
                        <label class="col-lg-2 control-label"><?php echo lang_check('Max images per property')?></label>
                            <div class="col-lg-10">
                                <?php echo form_input('max_images', $this->input->post('max_images') ? $this->input->post('max_images') : '1', 'class="form-control ui-state-valid"');?>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputOverwrite"><?php echo lang_check('Overwrite existing')?></label>
                          <div class="col-lg-10">
                          <?php echo form_checkbox('overwrite_existing', '1', false, 'id="inputOverwrite"')?>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputActivated"><?php echo lang_check('Import and activate')?></label>
                          <div class="col-lg-10">
                          <?php echo form_checkbox('activated', '1', true, 'id="inputActivated"')?>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputGoogle_gps"><?php echo lang_check('Use Google API, if gps are not available.')?></label>
                          <div class="col-lg-10">
                          <?php echo form_checkbox('google_gps', '1', true, 'id="inputGoogle_gps"')?>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <?php echo form_submit('submit', lang_check('Import'), 'class="btn btn-primary-blue"')?>
                            <a href="<?php echo site_url('admin/estate')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                          </div>
                        </div>
                    <?php echo form_close()?>
            </div>
            <div class="clearfix"></div>
            <div class="widget-foot">
<?php if(isset($imports)): ?>                     
    <p><?php _l('All property'); ?>: <?php echo count($imports);?></p>
    <p><?php _l('Added new'); ?>: <?php echo count($imports) - $skipped;?></p>
    <p><?php _l('Overwrite'); ?>: <?php echo  $count_exists_overwrite;?></p>
    <br/>
    <p><?php _l('Skipped'); ?>: <?php echo $skipped;?></p>
    <p><?php _l('Errors'); ?>: <?php echo $skipped-$count_exists;?></p>
    <p><?php _l('Exists skipped'); ?>: <?php echo $count_exists;?></p>
    <br/>
<?php endif; ?>
    
        <?php if (!empty($imports)): ?>
        <p><?php _l('Update/Import completed'); ?>:</p>
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th><?php _l('Address'); ?></th>
            </tr>
            <?php foreach ($imports as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><a href="<?php echo site_url('admin/estate/edit/'.$item['preview_id']); ?>"><?php echo $item['address']; ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p><?php _l('Example XML file'); ?>:</p>
        <br />
        <a class="label label-warning" target="_blank" href="http://www.xml2u.com/Xml/D%20Habitat%20L%20agence%20immobilier_795/1540_Default.xml"><?php _l('Examples and guides'); ?></a>
        <br /><br />
    <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<style type="text/css">
    .table.table-striped td {
        font-size: 14px;
        vertical-align: middle;
    }
    
    .table.table-striped td a:hover {
        text-decoration: underline!important;
    }
    
</style>
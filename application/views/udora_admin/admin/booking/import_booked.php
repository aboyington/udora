<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Import reservations')?></h3>
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
                <h2><?php echo lang('Reservations data')?></h2>
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
                </div>
                <!-- Form starts.  -->
                <?php echo form_open_multipart(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('XML File')?></label>
                      <div class="col-lg-10">
                        <input id="userfile_xml" type="file" name="userfile_xml" size="20" />
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang_check('Import'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/booking')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                    <?php echo form_close()?>
            </div>
            <div class="clearfix"></div>
                  <div class="widget-foot">
<?php if(count($import) > 0): ?>
<p><?php _l('Imports completed'); ?>:</p>
<table class="table table-striped">
<tr>
<th>#</th>
<th><?php _l('Imports'); ?></th>
</tr>
<tr>
<?php foreach($import as $property_id=>$property_imports): ?>
<td><?php echo $property_id; ?></td>
<td><?php echo $property_imports; ?></td>
<?php endforeach; ?>
</tr>
</table>
<?php else: ?>
                    <p><?php _l('Example XML file'); ?>:</p>
                    <pre>
<?php echo htmlentities('
<?xml version="1.0" encoding="UTF-8"?>
<properties>
    <property id="4034">
        <date>2015-05-18</date>
        <date>2015-05-19</date>
        <date>2015-05-20</date>
        <date>2015-05-21</date>
        <date>2015-05-22</date>
    </property>
    <property id="4035">
        <date>2015-05-18</date>
        <date>2015-05-19</date>
        <date>2015-05-20</date>
        <date>2015-05-21</date>
        <date>2015-05-22</date>
    </property>
</properties>
');
?>
                    </pre>
<?php endif; ?>
</div>
        </div>
    </div>
</div>



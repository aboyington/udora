<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Research')?></h3>
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
                <h2><?php echo empty($listing->id) ? lang_check('Add research') : lang_check('Edit research').' "' . $listing->id.'"'?></h2>
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
                <!-- Form starts.  -->
                 <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('User')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('user_id', $users, $this->input->post('user_id') ? $this->input->post('user_id') : $listing->user_id, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Activated')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('activated', '1', set_value('activated', $listing->activated), 'id="inputActivated"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Frequency of the delivery'); ?></label>
                      <div class="col-lg-10">
                      <?php 

                    $options = array(
                                      '0'   => lang_check('Instant'),
                                      '24'  => lang_check('Daily'),
                                      '168' => lang_check('Weekly')
                                    );

                    echo form_dropdown('delivery_frequency_h', $options, set_value('delivery_frequency_h', $listing->delivery_frequency_h), 'class="form-control"');

                      ?>
                      </div>
                    </div>
<div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/savesearch')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                <?php echo form_close()?>
<br/>
                <div class="widget-foot">
                    <!-- Footer goes here -->
                    <b><?php echo lang_check('Parameters').':'; ?></b><br />
                    <?php echo lang_check('Lang code').': '; ?><?php echo '['.strtoupper($listing->lang_code).']'; ?><br />
                    <?php
                    
                    $parameters = json_decode($listing->parameters);
                    
                    foreach($parameters as $key=>$value){
                        if(!empty($value)){
                            if(is_array($value))
                            {
                                $value = implode(', ', $value);
                            }
                            
                            echo $key.': <b>'.$value.'</b><br />';
                        }
                        
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
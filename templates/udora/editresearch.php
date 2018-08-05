<!DOCTYPE html>
<html>
<head>
    <?php _widget('head'); ?>
    <script src='assets/js/gmap3/gmap3.min.js'></script>
</head>
<body class="dashboard-body" id="main">
<?php _widget('header_menu'); ?>
<!-- Add Event -->
<div class="container dashboard-layout">
    <div class="raw">
        <div class="col-xs-12" style="padding-bottom: 30px;">
            <div class="col-md-3 hidden-xs hidden-sm pad0">
                <?php _widget('custom_loginusermenu');?>
            </div>
            <div class="col-xs-12 col-md-9 pad0">
                <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                    <div class="panel panel-default">
                        <div class="panel-heading">{lang_Editresearch}, #<?php echo $listing['id']; ?></div>
                        <div class="panel-body left-align">
                            <div class="form-group" id="add-event">
                            <div class="">
                                <?php echo validation_errors()?>
                                <?php if($this->session->flashdata('message')):?>
                                <?php echo $this->session->flashdata('message')?>
                                <?php endif;?>
                                <?php if($this->session->flashdata('error')):?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                <?php endif;?>
                            </div>
<div class="widget-content">
                                <?php echo form_open(NULL, array('class' => 'form-horizontal form-estate', 'role'=>'form'))?>                              
                                
                                <div class="control-group">
                                    <label for="inputActivated" class="control-label"><?php echo lang_check('Activated')?></label>
                                    <div class="controls">
                                         <?php echo form_checkbox('activated', '1', set_value('activated', $listing['activated']), 'id="inputActivated"')?>
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo lang_check('Parameters')?></label>
                                    <div class="controls">
                                        <?php echo lang_check('Lang code').': '; ?><?php echo '['.strtoupper($listing['lang_code']).']'; ?><br />
                                        <?php
                                        $parameters = json_decode($listing['parameters']);
                                        foreach($parameters as $key=>$value){
                                            if(!empty($value) && $key != 'view' && $key != 'order')
                                            {
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

                                <div class="form-group control-group rowp">
                                  <div class="controls">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-action-accept"')?>
                                    <a href="<?php echo site_url('fresearch/myresearch/'.$lang_code)?>#content" class="btn btn-action-unaccept" type="button"><?php echo lang('Cancel')?></a>
                                  </div>
                                </div>
                            <?php echo form_close()?>
                            </div>
                        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php _widget('custom_footer'); ?>
<?php _widget('custom_javascript'); ?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <?php _widget('head'); ?>
    <script src='assets/js/gmap3/gmap3.min.js'></script>
</head>
<body class="dashboard-body">
<?php _widget('header_menu'); ?>
<!-- Add Event -->
<div class="container dashboard-layout" id="main">
    <div class="raw">
        <div class="col-xs-12" style="padding-bottom: 30px;">
            <div class="col-md-3 hidden-xs hidden-sm pad0">
                 <?php _widget('custom_loginusermenu');?>
            </div>
            <div class="col-xs-12 col-md-9 pad0">
                <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php _l('Edit message'); ?> #<?php echo $enquire->id; ?></div>
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
                            <?php echo form_open(current_url() . '#form-block', array('class' => 'form-horizontal form-estate', 'role' => 'form')) ?>                              

                            <div class="control-group">
                                <label for="inputproperty_id" class="control-label"><?php _l('Estate'); ?></label>
                                <div class="controls">
                                    <?php echo form_dropdown('property_id', $all_estates, set_value('property_id', $enquire->property_id), ' id="inputproperty_id" class="form-control"'); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="inputNameSurname" class="control-label"><?php _l('Name and surname') ?></label>
                                <div class="controls">
                                    <?php echo form_input('name_surname', set_value('name_surname', $enquire->name_surname), 'class="form-control" id="inputNameSurname" placeholder="' . lang_check('Name and surname') . '"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="inputPhone" class="control-label"><?php _l('Phone') ?></label>
                                <div class="controls">
                                    <?php echo form_input('phone', set_value('phone', $enquire->phone), 'class="form-control" id="inputPhone" placeholder="' . lang_check('Phone') . '"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="inputMail" class="control-label"><?php _l('Mail') ?></label>
                                <div class="controls">
                                    <?php echo form_input('mail', set_value('mail', $enquire->mail), 'class="form-control" id="inputMail" placeholder="' . lang_check('Mail') . '"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php _l('FromDate') ?></label>
                                <div class="controls">
                                    <?php echo form_input('fromdate', set_value('fromdate', $enquire->fromdate), 'class="form-control datetimepicker_standard" data-format="yyyy-MM-dd"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"><?php _l('ToDate') ?></label>
                                <div class="controls">
                                    <?php echo form_input('todate', set_value('todate', $enquire->todate), 'class="form-control datetimepicker_standard" data-format="yyyy-MM-dd"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="inputMessage" class="control-label"><?php _l('Message') ?></label>
                                <div class="controls">
                                    <?php echo form_textarea('message', set_value('message', $enquire->message), 'placeholder="' . lang_check('Message') . '" id="inputMessage" rows="3" class="form-control"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="inputAddress" class="control-label"><?php _l('Address') ?></label>
                                <div class="controls">
                                    <?php echo form_textarea('address', set_value('address', $enquire->address), 'placeholder="' . lang_check('Address') . '" id="inputAddress" rows="3" class="form-control"') ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="inputReaded" class="control-label"><?php _l('Readed') ?></label>
                                <div class="controls">
                                    <?php echo form_checkbox('readed', '1', set_value('readed', $enquire->readed), 'id="inputReaded"') ?>
                                </div>
                            </div>

                            <div class="form-group control-group row">
                                <div class="controls">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-action-accept"') ?>
                                    <?php if (isset($enquire->mail)): ?>
                                        <a href="mailto:<?php echo $enquire->mail ?>?subject=<?php echo lang_check('Reply on question for real estate') ?>: <?php echo $all_estates[$enquire->property_id] ?>&amp;body=<?php echo $enquire->message ?>" class="btn btn-default" ><?php echo lang_check('Reply to email') ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php echo form_close() ?>
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

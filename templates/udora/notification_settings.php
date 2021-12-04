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
                <?php _widget('custom_login_profile'); ?>
                <?php _widget('custom_loginusermenu');?>
            </div>
            <div class="col-xs-12 col-md-9 pad0">
                <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                    <div class="panel panel-default notification-settings">
                        <div class="panel-heading"><?php echo lang_check('Notification Settings');?></div>
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
                                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                                <div class="">
                                    <label class="checkbox csscheckbox noanim" for="favorites_notifications">
                                        <?php echo form_checkbox('favorites_notifications','1', set_value('favorites_notifications', !empty($user_data['favorites_notifications'])? true : false), 'class="" id="favorites_notifications" placeholder="'.lang('Favorites notifications').'"')?>
                                        <span class="squaredCheckbox"></span>
                                        <?php echo lang_check('Favorites update notifications');?>
                                    </label>
                                    <p class="smallest-font">
                                        <?php echo lang_check('Favorites notifications info');?>
                                    </p>
                                    <br>
                                    <label class="checkbox csscheckbox noanim" for="reviews_notifications">
                                        <?php echo form_checkbox('reviews_notifications','1', set_value('reviews_notifications', $user_data['reviews_notifications']), 'class="" id="reviews_notifications" placeholder="'.lang('Reviews notifications').'"')?>
                                        <span class="squaredCheckbox"></span>
                                        <?php echo lang_check('Comment notifications')?>
                                    </label>
                                    <p class="smallest-font">
                                        <?php echo lang_check('Comment notifications info');?>
                                    </p>
                                    <br>
                                    <label class="checkbox csscheckbox noanim" for="promotional_emails">
                                        <?php echo form_checkbox('promotional_emails','1', set_value('promotional_emails', $user_data['promotional_emails']), 'class="" id="promotional_emails" placeholder="'.lang('Promotional Emails').'"')?>
                                        <span class="squaredCheckbox"></span>
                                        <?php echo lang_check('Promotional Emails');?>
                                    </label>
                                    <p class="smallest-font">
                                        <?php echo lang_check('Promotional Emails info');?>
                                    </p>
                                    <br>
                                    <label class="checkbox csscheckbox noanim" for="information_disclosed">
                                        <?php echo form_checkbox('information_disclosed','1', set_value('information_disclosed', $user_data['information_disclosed']), 'class="" id="information_disclosed" placeholder="'.lang('Information Disclosed').'"')?>
                                        <span class="squaredCheckbox"></span>
                                        <?php echo lang_check('Information Disclosed');?>
                                    </label>
                                    <p class="smallest-font">
                                        <?php echo lang_check('Information Disclosed info');?>
                                    </p>
                                    <br>
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-action-accept"')?>
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

<?php _widget('custom_footer'); ?>
<?php _widget('custom_javascript'); ?>
<script>
    $(document).ready(function(){
        $('body').append('<div id="blueimp-gallery" class="blueimp-gallery">\n\
                            <div class="slides"></div>\n\
                            <h3 class="title"></h3>\n\
                            <a class="prev">&lsaquo;</a>\n\
                            <a class="next">&rsaquo;</a>\n\
                            <a class="close">&times;</a>\n\
                            <a class="play-pause"></a>\n\
                            <ol class="indicator"></ol>\n\
                            </div>')
    })
</script>
</body>
</html>

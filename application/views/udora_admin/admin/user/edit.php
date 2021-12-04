<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo lang('User')?></h3>
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
                    <h2><?php echo lang_check('User Data');?></h2>
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
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar -->
                                <?php if(!empty($user->repository_id) && isset($files[$user->repository_id]) && !empty($files[$user->repository_id])):?>
                                <img class="img-responsive avatar-view" src="<?php _che($files[$user->repository_id][0]->thumbnail_url, '');?>" alt="Avatar" title="Change the avatar">
                                <?php endif;?>
                            </div>
                        </div>
                        <h3><?php _che( $user->name_surname,'');?></h3>

                        <ul class="list-unstyled user_data">
                            <?php if(!empty($user->address)):?>
                            <li><i class="fa fa-map-marker user-profile-icon"></i> <?php _che( $user->address,'');?>
                            </li>
                            <?php endif;?>
                            <?php if(!empty($user->type)):?>
                            <li>
                                <i class="fa fa-briefcase user-profile-icon"></i> <?php _che( $user->type,'');?>
                            </li>
                            <?php endif;?>
                            <?php if(!empty($user->mail)):?>
                            <li class="m-top-xs">
                                <i class="fa fa-external-link user-profile-icon"></i>
                                <a href="mailto:<?php _che( $user->mail,'');?>" target="_blank"><?php _che( $user->mail,'');?></a>
                            </li>
                            <?php endif;?>
                        </ul>
                    </div>

                    <!-- User Profile Form -->
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="padd-alert">
                            <?php echo validation_errors()?>
                            <?php if($this->session->flashdata('message')):?>
                            <?php echo $this->session->flashdata('message')?>
                            <?php endif;?>
                            <?php if($this->session->flashdata('error')):?>
                            <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                            <?php endif;?>     
                        </div>
                        <?php echo form_open(NULL, array('class' => 'form-horizontal form-label-left', 'role'=>'form'))?>              
                        <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Name and surname')?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('name_surname', set_value('name_surname', $user->name_surname), ' class="form-control col-md-7 col-xs-12"  required="required" id="inputNameSurname" placeholder="'.lang('Name and surname').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Username')?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('username', set_value('username', $user->username), ' class="form-control col-md-7 col-xs-12"  required="required" id="inputUsername" placeholder="'.lang('Username').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Password')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_password('password', set_value('password', ''), ' class="form-control col-md-7 col-xs-12" id="inputPassword" placeholder="'.lang('Password').'" autocomplete="off"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('PasswordConfirm')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_password('password_confirm', set_value('password_confirm', ''), ' class="form-control col-md-7 col-xs-12" id="inputPasswordConfirm" placeholder="'.lang('PasswordConfirm').'" autocomplete="off"')?>
                                  </div>
                                </div>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Age')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                     <?php echo form_input('age', set_value('age', $user->age), ' class="form-control col-md-7 col-xs-12" id="inputage" placeholder="'.lang('Age').'"')?>
                                  </div>
                                </div>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Gender')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_dropdown('gender', array_combine($this->user_m->user_gender,$this->user_m->user_gender), set_value('gender', $user->gender), ' class="form-control col-md-7 col-xs-12"');?>
                                  </div>
                                </div>
                        
                                <?php if($this->session->userdata('type') == 'ADMIN'): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Type')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_dropdown('type', $this->user_m->user_types, set_value('type', $user->type), ' class="form-control col-md-7 col-xs-12"');?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($this->session->userdata('type') == 'ADMIN' && file_exists(APPPATH.'controllers/admin/expert.php')): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Expert category')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_dropdown('qa_id', $expert_categories, set_value('qa_id', $user->qa_id), ' class="form-control col-md-7 col-xs-12"');?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($this->session->userdata('type') == 'ADMIN' && file_exists(APPPATH.'controllers/admin/packages.php')): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Package')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_dropdown('package_id', $packages, set_value('package_id', $user->package_id), ' class="form-control col-md-7 col-xs-12"');?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Package expire date')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  <div class="input-group date myDatepicker_full" id="datetimepicker1">
                                    <?php echo form_input('package_last_payment', $this->input->post('package_last_payment') ? $this->input->post('package_last_payment') : $user->package_last_payment, 'class="form-control" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                  </div>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($this->session->userdata('type') != 'AGENT_LIMITED'): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Address')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_textarea('address', set_value('address', $user->address), 'placeholder="'.lang('Address').'" rows="3"  class="form-control col-md-7 col-xs-12"')?>
                                  </div>
                                </div>       
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Description')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_textarea('description', set_value('description', $user->description), 'placeholder="'.lang('Description').'" rows="3"  class="form-control col-md-7 col-xs-12"')?>
                                  </div>
                                </div>     
                    
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Phone')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('phone', set_value('phone', $user->phone), ' class="form-control col-md-7 col-xs-12" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                                  </div>
                                </div>
                    
                                <?php if(config_db_item('phone_mobile_enabled') === TRUE): ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Mobile phone')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('phone2', set_value('phone2', $user->phone2), ' class="form-control col-md-7 col-xs-12" id="inputPhone2" placeholder="'.lang('Mobile phone').'"')?>
                                  </div>
                                </div>
                                <?php endif;?>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Mail')?> <span class="required">*</span></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('mail', set_value('mail', $user->mail), ' class="form-control col-md-7 col-xs-12" id="inputMail" placeholder="'.lang('Mail').'" data-validate-linked="email" required="required"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Language')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_dropdown('language', $this->language_m->backend_languages, set_value('language', $user->language), ' class="form-control col-md-7 col-xs-12"');?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($this->session->userdata('type') == 'ADMIN'): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Activated')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_checkbox('activated', '1', set_value('activated', $user->activated), 'id="inputActivated"')?>
                                  </div>
                                </div>
                                <?php endif; ?>

                                <?php if($this->session->userdata('type') != 'AGENT_LIMITED'): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Facebook ID')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('facebook_id', set_value('facebook_id', $user->facebook_id), ' class="form-control col-md-7 col-xs-12" id="inputMail" placeholder="'.lang_check('Facebook ID').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Embed video code')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_textarea('embed_video_code', set_value('embed_video_code', $user->embed_video_code), ' class="form-control col-md-7 col-xs-12" id="input_embed_video_code" placeholder="'.lang_check('Embed video code').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Payment details')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_textarea('payment_details', set_value('payment_details', $user->payment_details), ' class="form-control col-md-7 col-xs-12" id="input_payment_details" placeholder="'.lang_check('Payment details').'"')?>
                                  </div>
                                </div>

                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('facebook_link')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('facebook_link', set_value('facebook_link', $user->facebook_link), ' class="form-control col-md-7 col-xs-12" id="input_facebook_link" placeholder="'.lang_check('facebook_link').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('youtube_link')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('youtube_link', set_value('youtube_link', $user->youtube_link), ' class="form-control col-md-7 col-xs-12" id="input_youtube_link" placeholder="'.lang_check('youtube_link').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('gplus_link')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('gplus_link', set_value('gplus_link', $user->gplus_link), ' class="form-control col-md-7 col-xs-12" id="input_gplus_link" placeholder="'.lang_check('gplus_link').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('twitter_link')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('twitter_link', set_value('twitter_link', $user->twitter_link), ' class="form-control col-md-7 col-xs-12" id="input_twitter_link" placeholder="'.lang_check('twitter_link').'"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('linkedin_link')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_input('linkedin_link', set_value('linkedin_link', $user->linkedin_link), ' class="form-control col-md-7 col-xs-12" id="input_linkedin_link" placeholder="'.lang_check('linkedin_link').'"')?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($this->session->userdata('type') == 'ADMIN' && config_db_item('phone_verification_enabled') === TRUE && file_exists(APPPATH.'libraries/Clickatellapi.php')): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Phone verified')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  <?php echo form_checkbox('phone_verified', '1', set_value('phone_verified', $user->phone_verified), 'id="inputPhoneVerified"')?>
                                  </div>
                                </div>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Mail verified')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                  <?php echo form_checkbox('mail_verified', '1', set_value('mail_verified', $user->mail_verified), 'id="inputMailVerified"')?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if( config_db_item('agency_agent_enabled') === TRUE && $this->session->userdata('type') == 'ADMIN' ): ?>
                                
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php _l('Agency related')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_dropdown_ajax('agency_id', 'user_m', set_value('agency_id', $user->agency_id), 'username', NULL, TRUE);?>
                                  </div>
                                </div>
                                
                                <?php endif; ?>
                                
                                <?php if(config_db_item('enable_county_affiliate_roles') === TRUE && $this->session->userdata('type') == 'ADMIN' && FALSE): ?>
                                <div class="form-group search-form">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('County')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">

                                    <!-- [START] TreeSearch -->
                                    <?php if(config_item('tree_field_enabled') === TRUE):?>
                                    <?php

                                        $CI =& get_instance();
                                        $CI->load->model('treefield_m');
                                        $field_id = 64;
                                        $lang_id = $content_language_id;
                                        $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                                        $drop_selected = array();
                                        echo '<div class="tree TREE-GENERATOR tree-'.$field_id.'">';
                                        echo '<div class="field-tree">';
                                        echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                                        echo '</div>';

                                        $levels_num = $CI->treefield_m->get_max_level($field_id);

                                        if($levels_num>0)
                                        for($ti=1;$ti<=$levels_num;$ti++)
                                        {
                                            $lang_empty = lang_check('treefield_'.$field_id.'_'.$ti);
                                            if(empty($lang_empty))
                                                $lang_empty = lang_check('Please select parent');

                                            echo '<div class="field-tree">';
                                            echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_'.$ti, array(''=>$lang_empty), array(), 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_'.$ti.'"');
                                            echo '</div>';
                                        }
                                        echo '</div>';

                                    ?>

                                    <script language="javascript">

                                    $(function() {
                                        var load_val = '<?php echo set_value('county_affiliate_values', $user->county_affiliate_values); ?>';
                                        var s_values_splited = (load_val+" ").split(" - "); 
                    //            $.each(s_values_splited, function( index, value ) {
                    //                alert( index + ": " + value );
                    //            });
                                        if(s_values_splited[0] != '')
                                        {
                                            var first_select = $('.tree-64').find('select:first');
                                            first_select.find('option').filter(function () { return $(this).html() == s_values_splited[0]; }).attr('selected', 'selected');

                                            load_by_field(first_select, true, s_values_splited);
                                        }
                                    });

                                    </script>
                                    <?php endif; ?>
                                    <!-- [END] TreeSearch -->
                                    <?php echo form_input('county_affiliate_values', set_value('county_affiliate_values', $user->county_affiliate_values), 'class="form-control hidden" id="input_county_affiliate_values" placeholder="'.lang_check('County').'"')?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if(config_db_item('clickatell_api_id') != '' && file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('SMS notifications enabled')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_checkbox('research_sms_notifications', '1', set_value('research_sms_notifications', $user->research_sms_notifications), 'id="input_research_sms_notifications"')?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if(file_exists(APPPATH.'controllers/admin/savesearch.php')): ?>
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Enable Email alerts')?></label>
                                  <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php echo form_checkbox('research_mail_notifications', '1', set_value('research_mail_notifications', $user->research_mail_notifications), 'id="input_alerts_email"')?>
                                  </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- [Custom fields] -->                       
                                <?php
                                custom_fields_print('custom_fields_code');
                                ?>          
                                <!-- [/Custom fields] -->

                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                                     <a href="<?php echo site_url('admin/user')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- // User Profile Form -->


                </div>
            </div>
        </div>
    </div>
</div>



<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Images')?></h2>
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
            <?php if(!isset($user->id)):?>
            <span class="label label-danger"><?php echo lang('After saving, you can add files and images');?></span>
            <?php else:?>
            <p>By order, first image will be used as profile and second as agency logo.</p>
            <div class="page-files-box" id="page-files-<?php echo $user->id?>" rel="user_m">
                <!-- The file upload form used as target for the file upload widget -->
                <form class="fileupload" action="<?php echo site_url('files/upload_user/'.$user->id);?>" method="POST" enctype="multipart/form-data">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value="<?php echo site_url('admin/user/edit/'.$user->id);?>"></noscript>
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="fileupload-buttonbar row">
                        <div class="col-md-7">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-primary-blue fileinput-button">
                                <i class="fa fa-plus m-right-xs"></i>
                                <span><?php echo lang('add_files...')?></span>
                                <input type="file" name="files[]" multiple>
                            </span>
                            <button type="reset" class="btn btn-danger cancel">
                                <i class="fa fa-minus m-right-xs"></i>
                                <span><?php echo lang('cancel_upload')?></span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="fa fa-trash m-right-xs"></i>
                                <span><?php echo lang('delete_selected')?></span>
                            </button>
                            <input type="checkbox" class="toggle" />
                        </div>
                        <!-- The global progress information -->
                        <div class="col-md-5 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="bar" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress information -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The loading indicator is shown during file processing -->
                    <div class="fileupload-loading"></div>
                    <br />
                    <!-- The table listing the files available for upload/download -->
                    <!--<table role="presentation" class="table table-striped">
                    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">-->

                      <div role="presentation" class="fieldset-content">
                        <div class="row files files-list"  data-toggle="modal-gallery" data-target="#modal-gallery">
                        <?php if(isset($files[$user->repository_id]))foreach($files[$user->repository_id] as $file ):?>
                        <div class="col-md-55 img-rounded template-download fade in">
                            <div class="thumbnail">
                                <div class="image view view-first">
                                    <div class="preview">
                                        <img style="width: 100%; display: block;" data-src="<?php echo $file->thumbnail_url?>" src="<?php echo $file->thumbnail_url?>" alt="<?php echo $file->filename?>" />
                                    </div>
                                    <div class="mask">
                                        <p><?php echo character_hard_limiter($file->filename, 20)?></p>
                                        <div class="tools tools-bottom options-container">
                                            <?php if($file->zoom_enabled):?>
                                            <a class="zoom-button" rel="<?php echo $file->filename?>" href="<?php echo $file->download_url?>"><i class="fa icon-zoom-in"></i></a>
                                            <a data-gallery="gallery" href="<?php echo $file->download_url?>" title="<?php echo $file->filename?>" download="<?php echo $file->filename?>"><i class="fa fa-link"></i></a>                  
                                            <?php else:?>
                                            <a target="_blank" href="<?php echo $file->download_url?>" title="<?php echo $file->filename?>" download="<?php echo $file->filename?>"><i class="fa fa-link"></i></a>
                                            <?php endif;?>
                                            <div class="delete">
                                                <button class="" data-type="POST" data-url="<?php echo $file->delete_url?>"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <p><?php echo lang_check('Remove');?>
                                    <input type="checkbox" value="1" name="delete">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        </div>
                        <br style="clear:both;"/>
                      </div>
                </form>

            </div>

            <?php endif;?>
        </div>
    </div>
</div>

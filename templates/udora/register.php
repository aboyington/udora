<!DOCTYPE html>
<html>
    <head>
        <?php _widget('head'); ?>
    </head>
    <body class="body-login-register">
        <?php _widget('header_menu'); ?>
        <!-- Business hero  -->
        <div class="container register-login py-2 py-sm-4 px-0">
            <div class="raw">
                <div class="col-xs-12">
                    <?php if(file_exists(APPPATH.'controllers/admin/packages.php') && FALSE): ?>
                    <div class="col-xs-12 col-md-12 box-white section section-d12">
                        <div class="section-title">
                            <h3>{lang_AvailablePackages}</h3>
                        </div>
                        <div class="">
                            <?php if ($this->session->flashdata('error_package')): ?>
                                <p class="alert alert-error"><?php echo $this->session->flashdata('error_package') ?></p>
                            <?php endif; ?>
                            <table class="table table-striped footable">
                                <thead>
                                <th data-breakpoints="xs" data-type="number">#</th>
                                <th data-type="html"><?php echo lang_check('Package name'); ?></th>
                                <th data-type="html"><?php echo lang_check('Price'); ?></th>
                                <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Free property activation'); ?></th>
                                <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Days limit'); ?></th>
                                <th data-breakpoints="xs sm" data-type="html"><?php echo lang_check('Listings limit'); ?></th>
                                <th data-breakpoints="xs sm md" data-type="html"><?php echo lang_check('Free featured limit'); ?></th>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($packages)): foreach ($packages as $package):
                                            ?>
                                            <tr>
                                                <td><?php echo $package->id; ?></td>
                                                <td>
                                                    <?php echo $package->package_name; ?>
                                                    <?php echo $package->show_private_listings == 1 ? '&nbsp;<i class="fa fa-eye-open"></i>' : '&nbsp;<i class="fa fa-eye-close"></i>'; ?>
                                                </td>
                                                <td><?php echo $package->package_price . ' ' . $package->currency_code; ?></td>
                                                <td><?php echo $package->auto_activation ? '<i class="fa fa-ok"></i>' : '<i class="fa fa-remove"></i>'; ?></td>
                                                <td><?php echo $package->package_days; ?></td>
                                                <td><?php echo $package->num_listing_limit ?></td>
                                                <td><?php echo $package->num_featured_limit ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="20"><?php echo lang_check('Not available'); ?></td>
                                        </tr>
                                    <?php endif; ?>           
                                </tbody>
                            </table>
                            <?php if (isset($settings_activation_price) && isset($settings_featured_price) &&
                                    $settings_activation_price > 0 || $settings_featured_price > 0):
                                ?>
                                <p class="row-fluid clearfix">
                                    <br/>
                                    <?php if ($settings_activation_price > 0): ?>
                                        <?php echo lang_check('* Property activation price:') . ' ' . $settings_activation_price . ' ' . $settings_default_currency; ?><br />
                                    <?php endif; ?>
                                    <?php if ($settings_featured_price > 0): ?>
                                        <?php echo lang_check('* Property featured price:') . ' ' . $settings_featured_price . ' ' . $settings_default_currency; ?>
                                <?php endif; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-xs-12 col-md-6 col-md-offset-3 border-create-account">
                        <div class="login-form create-account-form create-account-page">
                            <div class="col-xs-12">
                            <h3><?php echo lang_check('Create An Account');?></h3>
                            <p class="sub-title text-left"><?php echo lang_check('Please fill in the below form to create an account.'); ?></p>
                            </div>
                            <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix')) ?>
                                <div class="login-inputs col-xs-12 col-lg-12 mb-1 mb-sm-2">
                                    <?php if ($this->session->flashdata('error_registration') != ''): ?>
                                        <p class="alert alert-success"><?php echo $this->session->flashdata('error_registration') ?></p>
                                    <?php endif; ?>
                                    <?php if ($is_registration): ?>
                                        <?php echo validation_errors() ?>
                                    <?php endif; ?>
                                    <?php if (config_db_item('register_reduced') == FALSE): ?>
                                        <?php echo form_input('username', set_value('username', ''), 'class="col-xs-12 col-lg-12" id="inputUsername2" placeholder="' . lang('Username') . '"') ?>
                                    <?php endif; ?>
                                    <?php echo form_input('mail', set_value('mail', ''), 'class="col-xs-12 col-lg-12" id="inputMail" placeholder="' . lang('Email') . '"') ?>
                                    <?php echo form_password('password', set_value('password', ''), 'class="col-xs-12 col-lg-12" id="inputPassword2" placeholder="' . lang('Password') . '" autocomplete="off"') ?>
                                   <?php echo form_password('password_confirm', 'auto', 'class="form-control hidden" id="inputPasswordConfirm" placeholder="'.lang('Confirmpassword').'" autocomplete="off"')?>
                                        <div class="row">
                                        <div class="col-xs-8">
                                        <?php echo form_input('name_surname', set_value('name_surname', ''), 'class="col-xs-12 col-lg-12" id="inputNameSurname" placeholder="' . lang('FirstLast') . '"') ?>
                                        </div>
                                        <div class="col-xs-4 hint-box">
                                        <?php echo form_input('age', set_value('age', ''), 'class="col-xs-12 col-lg-12" id="inputAge" placeholder="' . lang_check('Age') . '"') ?>
                                            <span class="hintlabel hint--top-left" aria-label="<?php echo lang_check('To sign up you must be 13 or older. Other people won\'t see your birthday');?>"><i class="fa fa-question" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <div class="clearfix text-left mb-1 mb-sm-2">
                                        <label class="login-checkbox">
                                        <?php echo form_radio('gender','male', '', 'class="" id="inputGender"') ?> <?php echo lang_check('Male');?>
                                        </label>
                                        <label class="login-checkbox">
                                        <?php echo form_radio('gender','female', '', 'class="" id="inputGender"') ?> <?php echo lang_check('Female');?>
                                        </label>
                                        <label class="login-checkbox">
                                        <?php echo form_radio('gender','custom', '', 'class="" id="inputGender"') ?> <?php echo lang_check('Custom');?>
                                        </label>
                                    </div>    
                                        
                                    <?php if (config_item('captcha_disabled') === FALSE): ?>
                                        <div class="control-group {form_error_captcha}" >
                                            <div class="row">
                                                <div class="col-lg-6" style="padding-top:5px;">
                                                    <?php echo $captcha['image']; ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input class="captcha {form_error_captcha}" style="width: 100%;" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                                    <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (config_item('recaptcha_site_key') !== FALSE): ?>
                                        <div class="row">
                                            <div class="col-xs-12 col-lg-12">
                                                <?php _recaptcha(false); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>  
                                </div>
                                <div class="col-xs-12">
                                    <button class="button-login col-xs-12" type="submit" ><?php echo lang_check('Sign up') ?></button>
                                </div>
                            <?php echo form_close(); ?>
                            <p class="font_small col-lg-12 privacy mb-3 mb-sm-5"><?php echo lang_check('By creating an account'); ?></p>
                            <div class="col-xs-12 mb-1 mb-sm-2">
                                <p class="separate mb-0">
                                    <span class="separate-content"><?php echo lang_check('Or sign up with'); ?></span>
                                </p>
                            </div>
                            <div class="col-xs-12 mb-4 mb-sm-5">
                                <?php if (config_item('appId') != '' && !empty($login_url_facebook)): ?>
                                    <a href="<?php echo $login_url_facebook; ?>" class="login-facebook">
                                        <?php echo lang_check('Facebook'); ?>
                                    </a>
                                <?php endif; ?>
                                <?php if (config_item('glogin_enabled')): ?>
                                    <a href="<?php echo site_url('api/google_login/'); ?>" class="login-google">
                                        <?php echo lang_check('Google+'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="login-footer flex">
                                <div class="info mr-2"><?php echo lang_check('Already have a Udora acccount?');?></div>
                                <div class="action d-flex align-items-center">
                                    <a href="<?php echo site_url('frontend/login');?>" class="btn button-login-inv"><?php echo lang_check('Log in');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block d-md-none">
            <?php _widget('custom_footer_menu');?>
        </div>
        <div class="d-none d-md-block">
            <?php _widget('custom_footer'); ?>
        </div>
        <?php _widget('custom_javascript'); ?>
    </body>
</html>

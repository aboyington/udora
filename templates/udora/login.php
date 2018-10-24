<!DOCTYPE html>
<html>
    <head>
        <?php _widget('head'); ?>
    </head>
    <body class="body-login-register">
        <?php _widget('header_menu'); ?>
        <!-- Business hero  -->
        <div class="container register-login py-2 py-sm-6 px-0">
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
                    <div class="col-xs-12 col-md-6 col-md-offset-3 border-login-account">
                        <div class="login-form login-on-page" id="login-modal">
                            <div class="col-xs-12">
                            <h3><?php echo lang_check('Hello');?></h3>
                            <p class="sub-title text-left"><?php echo lang_check('Let\'s make today a great day!'); ?></p>
                            </div>                           
                            <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix')) ?>
                            <?php if ($is_login): ?>
                                <div class="login-inputs col-xs-12 col-lg-12">
                                    <?php echo validation_errors() ?>
                                    <?php if ($this->session->flashdata('error')): ?>
                                        <p class="alert alert-error"><?php echo $this->session->flashdata('error') ?></p>
                                    <?php endif; ?>
                                    <?php flashdata_message(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="login-inputs col-xs-12 col-lg-12">
                                <?php echo form_input('username', $this->input->get('username'), 'class="col-xs-12 col-lg-12" id="inputUsername" placeholder="' . lang('Username') . '"') ?>
                                <?php echo form_password('password', $this->input->get('password'), 'class="col-xs-12 col-lg-12" id="inputPassword" placeholder="' . lang('Password') . '"') ?>
                            </div>
                            <div class="col-xs-12 mb-2 mb-sm-3">
                                <div class="row d-flex align-items-center">
                                    <div class="checkbox remember-me col-xs-6 pt-0 d-flex align-items-center">
                                        <input name="remember-me" type="checkbox" value="true"  id="remember-me">
                                        <label for="remember-me" class="text-sm"><?php echo lang('Remember me') ?></label>
                                    </div>
                                    <div class="col-xs-6 text-right d-flex align-items-center justify-content-end">
                                        <a class="text-sm" href="<?php echo site_url('admin/user/forgetpassword'); ?>"><?php echo lang_check('Forget password?') ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 mb-3 mb-sm-4">
                                <button class="button-login col-xs-12 col-lg-12" type="submit"><?php echo lang_check('Login'); ?></button>
                            </div>
                            <?php echo form_close() ?>
                            <div class="col-xs-12 mb-1 mb-sm-2">
                                <p class="separate mb-0">
                                    <span class="separate-content"><?php echo lang_check('Or login with email'); ?></span>
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
                                <div class="info mr-2"><?php echo lang_check('Don\'t have and account?');?></div>
                                <div class="action d-flex align-items-center">
                                    <a href="<?php echo site_url('frontend/register');?>" class="btn button-login-inv"><?php echo lang_check('Sign up');?></a>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <script>
            /*
             * http://fooplugins.github.io/FooTable/docs/getting-started.html
             */

            $('document').ready(function () {
                $('.footable').footable({
                    "filtering": {
                        "enabled": false
                    },
                });
            })

        </script>
        <?php _widget('custom_footer_menu');?>
        <?php _widget('custom_footer'); ?>
        <?php _widget('custom_javascript'); ?>
    </body>
</html>

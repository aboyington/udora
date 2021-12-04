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
                    <div class="login-form login-on-page" id="login-modal">
                        <div class="col-xs-12">
                            <h3 class="text-center / mb-1"><?php echo lang_check('Welcome to Udora'); ?></h3>
                        </div>                           
                        <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id'=>'popup_form_login')) ?>
                        <div class="col-xs-12 alerts-box">
                        </div>
                        <div class="login-inputs col-xs-12 flabel-anim">
                            <div class="form-group">
                                <?php echo form_input('username', $this->input->get('username'), 'class="col-xs-12 col-lg-12 form-control" id="inputUsername"  autocomplete="username" placeholder="' . lang('Email') . '"') ?>
                                <label><?php echo lang_check("Email address");?></label>
                            </div>
                            <div class="form-group">
                                <?php echo form_password('password', $this->input->get('password'), 'class="col-xs-12 col-lg-12 form-control" id="inputPassword"  autocomplete="current-password" placeholder="' . lang('Password') . '"') ?>
                                <label><?php echo lang_check("Password");?></label>
                            </div>
                        </div>
                        <div class="col-xs-12 mb-2 mb-sm-3">
                            <button class="button-login col-xs-12 col-lg-12" type="submit"><?php echo lang_check('Log In');?>
                                <div class="spinner hidden ajax-indicator">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </button>
                        </div>
                        <?php echo form_close() ?>
                        <div class="col-xs-12 mb-1 mb-sm-2">
                            <p class="separate mb-0">
                                <span class="separate-content"><?php echo lang_check('OR'); ?></span>
                            </p>
                        </div>
                        <div class="col-xs-12 mb-3 login_buttons">
                            <?php if (config_item('appId') != '' && !empty($login_url_facebook)): ?>
                                <a href="<?php echo $login_url_facebook; ?>" class="btn-login-soc">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                    <?php echo lang_check('Facebook'); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (config_item('glogin_enabled')): ?>
                                <a href="<?php echo site_url('api/google_login/'); ?>" class="btn-login-soc">
                                    <i class="fa fa-google" aria-hidden="true"></i>
                                    <?php echo lang_check('Google+'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm mb-3 pl-2 pr-2"><?php echo lang_check("By countinuing, you agree to Udora's");?> <a href="#"><?php echo lang_check('Terms of Service, Privacy Policy');?></a></p>
                        <div class="login-footer">
                            <?php echo lang_check('Don\'t have an account?');?>
                             <a href="<?php echo site_url('frontend/register');?>" class="button-login-inv"><?php echo lang_check('Sign up');?></a>
                            <a class="link_forg" href="<?php echo site_url('admin/user/forgetpassword'); ?>"><?php echo lang_check('Forget password?') ?></a>
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
<div class="d-block d-md-none">
    <?php _widget('custom_footer_menu');?>
</div>

<a href="#" class="js-toogle-footermenu">
    <i class="material-icons">
    playlist_add
    </i>
    <i class="close-icon"></i>
</a>
        <div class="d-none d-sm-block">
            <?php _widget('custom_footer'); ?>
        </div>
        <?php _widget('custom_javascript'); ?>
    </body>
</html>

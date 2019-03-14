
<?php
$CI = &get_instance();
$login_url_facebook = '';
if ($CI->config->item('facebook_api_version') == '2.4' || floatval($this->config->item('facebook_api_version')) >= 2.4
    || version_compare($CI->config->item('facebook_api_version'), 2.4, '>')
) {
    $user_facebook = FALSE;
    if ($CI->config->item('appId') != '') {
        $CI->load->library('facebook/Facebook'); // Automatically picks appId and secret from config
        $user_facebook = $CI->facebook->getUser();
    }
    if ($user_facebook) {
    } else if ($CI->config->item('appId') != '') {
        $login_url_facebook = $CI->facebook->login_url();
    }
} else {
    $user_facebook = FALSE;
    if ($CI->config->item('appId') != '') {
        $CI->load->library('facebook'); // Automatically picks appId and secret from config
        $user_facebook = $CI->facebook->getUser();
    }
    $login_url_facebook = '';
    if ($user_facebook) {
    } else if ($CI->config->item('appId') != '') {
        $login_url_facebook = $CI->facebook->getLoginUrl(array(
            'redirect_uri' => site_url('frontend/login/' . $this->data['lang_code']),
            'scope' => array("email") // permissions here
        ));
    }
}
?>
<style>
    #codeigniter_profiler {
        display: none;
    }

    .navbar {
        position: absolute !important;
    }

</style>
<div class="page-popup-wrapper left-menu-wrapper page-login page-popup-transparent js-popup-login">
    <div class="left-menu py-1 px-1 py-sm-6 px-sm-2">
        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-xs-12 col-md-6 text-left / d-none d-md-block">
                    <h2 class="color-accent / mb-4">Find your next <span class="color-white">experience</span></h2>
                    <ol class="ordered-list-style-1">
                        <li class="color-white"><span class="color-accent">Explore local events</span> local or
                            worldwide
                        </li>
                        <li class="color-white"><span class="color-accent">Join the community</span> make connections
                        </li>
                        <li class="color-white"><span class="color-accent">Make your voice heard</span> how did we do
                        </li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="login__box-1 login-form login-on-page" id="login-modal">
                        <h3 class="text-center / mb-1"><?php echo lang_check('Live Love Life'); ?></h3>
                        <p class="sub-title / mb-3">{lang_Sign in slogan}</h4>
                            <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id' => 'popup_form_login')) ?>
                        <div class="login-inputs alerts-box">
                        </div>
                        <div class="login-inputs">
                            <?php echo form_input('username', $this->input->get('username'), 'class="w-100" id="inputUsername" placeholder="' . lang('Email') . '"') ?>
                            <?php echo form_password('password', $this->input->get('password'), 'class="w-100" id="inputPassword" placeholder="' . lang('Password') . '"') ?>
                        </div>
                        <div class="mb-2 mb-sm-3">
                            <div class="row d-flex align-items-center">
                                <div class="checkbox remember-me col-xs-6 pt-0 d-flex align-items-center">
                                    <input name="remember-me" type="checkbox" value="true" id="remember-me">
                                    <label for="remember-me" class="text-sm"> <?php echo lang('Remember me') ?></label>
                                </div>
                                <div class="col-xs-6 text-right d-flex align-items-center justify-content-end">
                                    <a class="text-sm"
                                       href="<?php echo site_url('admin/user/forgetpassword'); ?>"><?php echo lang_check('Forget password?') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 mb-sm-3">
                            <button class="button-login w-100" type="submit">{lang_Sign in}
                                <div class="spinner hidden ajax-indicator">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </button>
                        </div>
                        <?php echo form_close() ?>
                        <div class="mb-1 mb-sm-3">
                            <p class="separate mb-0">
                                <span class="separate-content"><?php echo lang_check('OR'); ?></span>
                            </p>
                        </div>
                        <div class="mb-1">
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
                        <p class="text-sm mb-3 pl-2 pr-2">{lang_By continuing}</p>
                        <div class="login-footer flex">
                            <div class="info mr-2"><?php echo lang_check('Don\'t have an account?'); ?></div>
                            <div class="action d-flex align-items-center">
                                <button class="btn button-login-inv js-toggle-register-popup">{lang_Try it free}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 text-left pt-6 pb-6 / d-md-none">
                    <h2 class="color-accent text-center  mb-2">Find your next <span
                                class="color-white">experience</span></h2>
                    <ol class="ordered-list-style-1 text-center">
                        <li class="color-white"><span class="color-accent">Explore local events</span> local or
                            worldwide
                        </li>
                        <li class="color-white"><span class="color-accent">Join the community</span> make connections
                        </li>
                        <li class="color-white"><span class="color-accent">Make your voice heard</span> how did we do
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-popup-wrapper left-menu-wrapper page-register page-popup-transparent js-register-popup">
    <div class="left-menu py-1 px-1 py-sm-6 px-sm-2">

        <div class="container">
            <div class="row d-flex flex-wrap align-items-center">
                <div class="col-xs-12 col-md-6 text-left / d-none d-md-block">
                    <h2 class="color-accent / mb-4">Find your next <span class="color-white">experience</span></h2>
                    <ol class="ordered-list-style-1">
                        <li class="color-white"><span class="color-accent">Explore local events</span> local or
                            worldwide
                        </li>
                        <li class="color-white"><span class="color-accent">Join the community</span> make connections
                        </li>
                        <li class="color-white"><span class="color-accent">Make your voice heard</span> how did we do
                        </li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="login__box-1 login-form create-account-form create-account-page">
                        <h3 class="text-center / mb-1">{lang_Welcome to Udora}</h3>
                        <p class="sub-title / mb-3">{lang_Sign up slogan}</p>
                        <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id' => 'popup_form_register')) ?>
                        <div class="login-inputs alerts-box">
                        </div>
                        <div class="login-inputs mb-1 mb-sm-2">
                            <?php if (config_db_item('register_reduced') == FALSE): ?>
                                <?php echo form_input('username', set_value('username', ''), 'class="w-100" id="inputUsername2" placeholder="' . lang('Username') . '"') ?>
                            <?php endif; ?>
                            <?php echo form_input('name_surname', set_value('name_surname', ''), 'class="col-xs-12 col-lg-12" id="inputNameSurname" placeholder="' . lang('FirstLast') . '"') ?>
                            <?php echo form_input('mail', set_value('mail', ''), 'class="w-100" id="inputMail" placeholder="' . lang('Email') . '"') ?>
                            <?php echo form_password('password', set_value('password', ''), 'class="w-100" id="inputPassword2" placeholder="' . lang('Password') . '" autocomplete="off"') ?>
                            <?php echo form_password('password_confirm', 'auto', 'class="form-control hidden" id="inputPasswordConfirm" placeholder="' . lang('Confirmpassword') . '" autocomplete="off"') ?>
                            <div class="hint-box">
                                <?php echo form_input('age', set_value('age', ''), 'class="w-100" id="inputAge" placeholder="' . lang_check('Age') . '"') ?>
                                <span class="hintlabewl hint--top-left"
                                      aria-label="<?php echo lang_check('To sign up you must be 13 or older. Other people won\'t see your birthday'); ?>"><i
                                            class="fa fa-question" aria-hidden="true"></i></span>
                            </div>
                            <div class="clearfix text-left mb-1 mb-sm-2">
                                <label class="login-checkbox">
                                    <?php echo form_radio('gender', 'male', '', 'class="mr-1" id="Male"') ?><?php echo lang_check('Male'); ?>
                                </label>
                                <label class="login-checkbox">
                                    <?php echo form_radio('gender', 'female', '', 'class="mr-1" id="Female"') ?><?php echo lang_check('Female'); ?>
                                </label>
                                <label class="login-checkbox">
                                    <?php echo form_radio('gender', 'custom', '', 'class="mr-1" id="Custom"') ?><?php echo lang_check('Custom'); ?>
                                </label>
                            </div>

                            <?php if (config_item('captcha_disabled') === FALSE): ?>
                                <div class="control-group {form_error_captcha}">
                                    <div class="row">
                                        <div class="col-lg-6" style="padding-top:5px;">
                                            <?php echo $captcha['image']; ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="captcha {form_error_captcha}" style="width: 100%;"
                                                   name="captcha"
                                                   type="text" placeholder="{lang_Captcha}" value=""/>
                                            <input class="hidden" name="captcha_hash" type="text"
                                                   value="<?php echo $captcha_hash; ?>"/>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (config_item('recaptcha_site_key') !== FALSE): ?>
                                <?php _recaptcha(false); ?>
                            <?php endif; ?>
                        </div>
                        <button class="button-login w-100 mb-1" type="submit">{lang_Join now}
                            <div class="spinner hidden ajax-indicator">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </button>
                        <?php echo form_close(); ?>
                        <p class="text-sm mb-3 pl-2 pr-2">{lang_By continuing}</p>
                        <p class="separate mb-2 text-center">
                            <span class="separate-content"><?php echo lang_check('OR'); ?></span>
                        </p>
                        <div class="mb-3 mb-sm-4">
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
                            <div class="info mr-2"><?php echo lang_check('Already have a Udora acccount?'); ?></div>
                            <div class="action d-flex align-items-center">
                                <button class="js-toggle-login-popup btn button-login-inv">{lang_Sign in}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 text-left pt-6 pb-6 / d-md-none">
                    <h2 class="color-accent text-center  mb-2">Find your next <span
                                class="color-white">experience</span></h2>
                    <ol class="ordered-list-style-1 text-center">
                        <li class="color-white"><span class="color-accent">Explore local events</span> local or
                            worldwide
                        </li>
                        <li class="color-white"><span class="color-accent">Join the community</span> make connections
                        </li>
                        <li class="color-white"><span class="color-accent">Make your voice heard</span> how did we do
                        </li>
                    </ol>
                </div>
            </div>
        </div>


    </div>
</div>


<nav class="mobile-menu" id="js-mobile-menu">
    <button type="button" role="button" class="navbar__gamburger__icon / white / js-toggle-mobile-navbar x" aria-label="Toggle Navigation" aria-expanded="false">
        <span class="lines"></span>
    </button>
    <ul class="mobile-menu__links">
        <li class="mobile-menu__links__item"><a
                    href="<?php echo site_url($lang_code); ?>"><?php echo lang_check('Home'); ?></a></li>
        <li class="mobile-menu__links__item"><a
                    href="<?php echo site_url($lang_code . '/179/blog_page'); ?>"><?php echo lang_check('About'); ?></a>
        </li>
        {is_logged_user}
        <li class="mobile-menu__links__item">
            <a role="button" data-toggle="collapse" href="#mobileMenuLoggedSubmenu" aria-expanded="false"
               aria-controls="mobileMenuLoggedSubmenu"><?php echo lang_check('My account'); ?>
                <i class="ion-android-arrow-dropdown icon-collapsed"></i>
                <i class="ion-android-arrow-dropup icon-not-collapsed"></i>
            </a>
            <div class="collapse" id="mobileMenuLoggedSubmenu">
                <ul class="mobile-menu__links mobile-menu__links--submenu">
                    <li class="mobile-menu__links__item">
                        <a href="{myproperties_url}#content"><?php echo lang_check('Dashboard'); ?></a>
                    </li>
                    <li class="mobile-menu__links__item">
                        <a href="{myprofile_url}#content"><?php echo lang_check('My Profile'); ?></a>
                    </li>
                    <li class="mobile-menu__links__item">
                        <a href="<?php echo site_url('frontend/editproperty/' . $lang_code . '#content'); ?>"><?php echo lang_check('Add Events'); ?></a>
                    </li>
                    <li class="mobile-menu__links__item">
                        <a href="{myfavorites_url}#content"><?php echo lang_check('Saved Events'); ?></a>
                    </li>
                    <li class="mobile-menu__links__item">
                        <a href="<?php echo site_url('frontend/notificationsettings/' . $lang_code . '#content'); ?>"><?php echo lang_check('Notifications'); ?></a>
                    </li>
                </ul>
            </div>
        </li>
        {/is_logged_user}
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/6/map'); ?>"><?php echo lang_check('Map'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/142/blog_page'); ?>"><?php echo lang_check('Blog'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/147/featured'); ?>"><?php echo lang_check('Featured'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/180/udora_for_business'); ?>"><?php echo lang_check('Business'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/182/terms_of_service'); ?>"><?php echo lang_check('Terms & Privacy'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="https://udora.io/support/"><?php echo lang_check('Help'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/4/contact'); ?>"><?php echo lang_check('Contact'); ?></a>
        </li>
        <li>
            <hr>
        </li>
        <li class="mobile-menu__links__item">
            <ul class="mobile-menu__links__item__social">
                <li>
                    <a href="https://www.facebook.com/share.php?u=https://udora.io/production/&amp;title=Udora"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 508 508">
                            <path d="M504 378.8c0 68.8-56.4 125.2-125.2 125.2H129.2C60.4 504 4 447.6 4 378.8V129.2C4 60.4 60.4 4 129.2 4h249.6C447.6 4 504 60.4 504 129.2v249.6z"
                                  fill="#235b9e"/>
                            <path d="M214.4 408.8H274V254h47.2l5.6-63.6H278v-24c0-12 7.6-16 13.2-16h34.4v-52h-48.8c-53.6 0-66.4 40-66.4 65.2v27.2h-27.6V254h31.6v154.8z"
                                  fill="#fff"/>
                            <path d="M274 412.8h-59.6c-2.4 0-4-1.6-4-4V258h-27.6c-2.4 0-4-1.6-4-4v-63.6c0-2.4 1.6-4 4-4h23.6v-23.2c0-33.2 18.4-69.2 70.4-69.2h48.8c2.4 0 4 1.6 4 4v52.8c0 2.4-1.6 4-4 4h-34.4c-2 0-9.2.8-9.2 12v20h44.8c1.2 0 2 .4 2.8 1.2s1.2 2 1.2 3.2l-5.6 63.6c0 2-2 3.6-4 3.6H278V306c0 2.4-1.6 4-4 4s-4-1.6-4-4v-52c0-2.4 1.6-4 4-4h43.6l4.8-55.6H278c-2.4 0-4-1.6-4-4v-24c0-13.6 8.8-20 17.2-20h30.4V102h-44.8c-10.4 0-62.4 2.8-62.4 61.2v27.2c0 2.4-1.6 4-4 4h-23.6V250h27.6c2.4 0 4 1.6 4 4v150.8H270v-31.6c0-2.4 1.6-4 4-4s4 1.6 4 4v35.6c0 2-2 4-4 4z"/>
                            <path d="M378.8 508H129.2C58 508 0 450 0 378.8V129.2C0 58 58 0 129.2 0h249.6C450 0 508 58 508 129.2v249.6C508 450 450 508 378.8 508zM129.2 8C62.4 8 8 62.4 8 129.2v249.6C8 445.6 62.4 500 129.2 500h249.6c66.8 0 121.2-54.4 121.2-121.2V129.2C500 62.4 445.6 8 378.8 8H129.2z"/>
                            <path d="M370 484H138c-62 0-114-52.4-114-114.4V138C24 76 76 24 138 24h231.2c2.4 0 4 1.6 4 4s-1.6 4-4 4H138C80.4 32 32 80.4 32 138v232c0 57.6 48.8 106.4 106 106.4h232c57.6 0 106-48.8 106-106.4V258c0-2.4 1.6-4 4-4s4 1.6 4 4v112c0 62-52 114-114 114z"/>
                            <path d="M446.8 65.2c-1.2 0-2-.4-2.8-1.2-20.4-20.4-47.6-32-75.2-32-2.4 0-4-1.6-4-4s1.6-4 4-4c29.6 0 58.8 12.4 80.8 34.4 1.6 1.6 1.6 4 0 5.6-.4.8-1.6 1.2-2.8 1.2zM480 234c-2.4 0-4-1.6-4-4v-59.2c0-2.4 1.6-4 4-4s4 1.6 4 4V230c0 2.4-1.6 4-4 4z"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/home?status=Udora%20https://udora.io/production/"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 508 508">
                            <path d="M504 378.8c0 68.8-56.4 125.2-125.2 125.2H129.2C60.4 504 4 447.6 4 378.8V129.2C4 60.4 60 4 129.2 4h249.6C447.6 4 504 60.4 504 129.2v249.6z"
                                  fill="#00abe3"/>
                            <path d="M401.2 134c-12.4 7.2-26 12.4-40.8 15.2-11.6-12.4-28.4-20-46.8-20-35.2 0-64 28.4-64 63.2 0 4.8.4 9.6 1.6 14.4-53.2-2.8-100.4-27.6-132-66-5.6 9.2-8.8 20-8.8 31.6 0 22 11.6 41.2 28.8 52.4-10.4-.4-20.8-3.2-28.4-8v.8c0 30.4 21.6 56 50.8 61.6-5.2 1.6-11.2 2.4-17.2 2.4-4 0-8.4-.4-12-1.2 8 25.2 31.6 43.2 59.6 43.6-22 16.8-49.6 26.8-79.6 26.8-5.2 0-10.4-.4-15.2-.8 28.4 18 62 28.4 98 28.4 117.6 0 182-96 182-179.2v-8c12.4-8.8 23.2-20 32-32.8-11.6 5.2-24 8.4-36.8 10 14-7.6 24-20 28.8-34.4"
                                  fill="#fff"/>
                            <path d="M378.8 508H129.2C58 508 0 450 0 378.8V129.2C0 58 58 0 129.2 0h249.6C450 0 508 58 508 129.2v249.6C508 450 450 508 378.8 508zM129.2 8C62.4 8 8 62.4 8 129.2v249.6C8 445.6 62.4 500 129.2 500h249.6c66.8 0 121.2-54.4 121.2-121.2V129.2C500 62.4 445.6 8 378.8 8H129.2z"/>
                            <path d="M370 484H138c-62 0-114.4-52.4-114.4-114.4V138C24 76 76 24 138 24h230.8c2.4 0 4 1.6 4 4s-1.6 4-4 4H138C80.4 32 32 80.4 32 138v232c0 57.6 48.8 106.4 106.4 106.4h232c57.6 0 106-48.8 106-106.4V258c0-2.4 1.6-4 4-4s4 1.6 4 4v112C484 432 432 484 370 484z"/>
                            <path d="M447.2 65.2c-1.2 0-2-.4-2.8-1.2-20.4-20.4-47.6-32-75.2-32-2.4 0-4-1.6-4-4s1.6-4 4-4c29.6 0 59.2 12.4 80.8 34.4 1.6 1.6 1.6 4 0 5.6-.8.8-2 1.2-2.8 1.2zM480 234c-2.4 0-4-1.6-4-4v-59.2c0-2.4 1.6-4 4-4s4 1.6 4 4V230c0 2.4-1.6 4-4 4zM377.6 203.6c-2.4 0-4-1.6-4-4v-8c0-1.2.4-2.8 1.6-3.6 8.4-6 16-12.8 22.8-20.8-8 2.4-16.4 4.4-24.8 5.2-2 .4-3.6-.8-4.4-2.8s0-3.6 1.6-4.8c12.4-7.2 22-18.8 26.4-32.8.8-2 2.8-3.2 5.2-2.4 2 .8 3.2 2.8 2.4 5.2-3.2 10-8.8 19.2-16.4 26.8 6.8-1.6 13.2-4 19.6-6.8 1.6-.8 3.6-.4 4.8 1.2 1.2 1.2 1.2 3.2.4 4.8-8.4 12.4-18.8 23.2-31.2 32.4v6c0 2.4-2 4.4-4 4.4z"/>
                            <path d="M195.2 382.8c-35.6 0-70.4-10-100.4-28.8-1.6-.8-2.4-2.8-1.6-4.8s2.4-2.8 4.4-2.8c30 3.6 59.2-3.6 83.2-19.2-24.4-4.4-44.8-21.6-52.4-45.6-.4-1.2 0-2.8.8-4s2.4-1.6 3.6-1.2c3.6.8 7.6 1.2 11.2 1.2-22.4-11.2-37.2-34-37.2-60v-.8c0-1.6.8-2.8 2-3.6s2.8-.8 4 0c3.6 2.4 8 4 12.4 5.2-12.4-12.4-19.6-29.2-19.6-46.4 0-12 3.2-23.6 9.2-33.6.8-1.2 2-2 3.2-2s2.4.4 3.2 1.6c30.8 37.2 75.6 60.4 124 64-.4-3.2-.8-6.8-.8-10 0-36.8 30.4-67.2 68-67.2 18 0 35.2 7.2 48 19.6 13.2-2.8 25.6-7.6 37.2-14.4 2-1.2 4.4-.4 5.6 1.6s.4 4.4-1.6 5.6c-13.2 7.6-27.2 12.8-42 15.6-1.2.4-2.8 0-3.6-1.2-11.2-12-27.2-18.8-44-18.8-33.2 0-60 26.4-60 59.2 0 4.4.4 9.2 1.6 13.6.4 1.2 0 2.4-.8 3.6s-2 1.6-3.2 1.6c-50.4-2.4-98-25.2-130.8-62.8-3.6 7.6-5.6 16-5.6 24.8 0 19.6 10.4 38 27.2 49.2 1.6.8 2 2.8 1.6 4.4-.4 1.6-2 2.8-4 2.8-8.4-.4-16.8-2-24-5.2 2.4 25.6 21.6 46.8 47.2 52 2 .4 3.2 2 3.2 3.6 0 2-1.2 3.6-2.8 4-7.6 2-16 2.8-24.4 2 9.6 20.8 30.4 34.4 53.6 34.8 1.6 0 3.2 1.2 3.6 2.8.4 1.6 0 3.2-1.2 4.4-23.2 18-51.2 27.6-80.4 27.6 25.2 12.8 52.8 19.6 81.6 19.6 61.2 0 113.2-26.8 146.4-75.6 1.2-2 3.6-2.4 5.6-1.2 2 1.2 2.4 3.6 1.2 5.6-33.6 51.2-88 79.2-152.4 79.2z"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://plus.google.com/share?url=https://udora.io/production/"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 508 508">
                            <style>.st1 {
                                    display: inline
                                }

                                .st2 {
                                    fill: #dc4e41
                                }

                                .st3 {
                                    fill: #fff
                                }</style>
                            <path class="st2"
                                  d="M504 378.8c0 68.8-56.4 125.2-125.2 125.2H129.2C60.4 504 4 447.6 4 378.8V129.2C4 60.4 60.4 4 129.2 4h249.6C447.6 4 504 60.4 504 129.2v249.6z"/>
                            <path d="M378.8 508H129.2C58 508 0 450 0 378.8V129.2C0 58 58 0 129.2 0h249.6C450 0 508 58 508 129.2v249.6C508 450 450 508 378.8 508zM129.2 8C62.4 8 8 62.4 8 129.2v249.6C8 445.6 62.4 500 129.2 500h249.6c66.8 0 121.2-54.4 121.2-121.2V129.2C500 62.4 445.6 8 378.8 8H129.2z"/>
                            <path d="M370 484H138c-62 0-114-52.4-114-114.4V138C24 76 76 24 138 24h231.2c2.4 0 4 1.6 4 4s-1.6 4-4 4H138C80.4 32 32 80.4 32 138v232c0 57.6 48.8 106.4 106 106.4h232c57.6 0 106-48.8 106-106.4V258c0-2.4 1.6-4 4-4s4 1.6 4 4v112c0 62-52 114-114 114z"/>
                            <path d="M446.8 65.2c-1.2 0-2-.4-2.8-1.2-20.4-20.4-47.6-32-75.2-32-2.4 0-4-1.6-4-4s1.6-4 4-4c29.6 0 58.8 12.4 80.8 34.4 1.6 1.6 1.6 4 0 5.6-.4.8-1.6 1.2-2.8 1.2zM480 234c-2.4 0-4-1.6-4-4v-59.2c0-2.4 1.6-4 4-4s4 1.6 4 4V230c0 2.4-1.6 4-4 4z"/>
                            <path class="st3"
                                  d="M286.9 226.3c4.8 0 9.5.1 14.3.1 2.4 34.4-2.7 71.2-25 98.8-30.6 39.4-87.2 51-133.2 35.5-48.8-16-84.4-65.2-83.3-116.8-2.4-63.7 53.4-122.6 117.2-123.4 32.5-2.8 64.1 9.9 88.7 30.4-10.1 11.1-20.4 22.1-31.3 32.3-21.7-13.1-47.7-23.2-73.1-14.3-40.8 11.6-65.6 59.8-50.4 99.8 12.5 41.7 63.2 64.6 103 47.1 20.6-7.4 34.1-26.3 40.1-46.8-23.6-.5-47.2-.2-70.8-.8-.1-14-.1-28-.1-42 13.4 0 26.8-.1 40.1-.1l63.8.2z"/>
                            <path d="M184 372c-14.5 0-29-2.3-42.6-6.9C90.3 348.3 53.9 297.4 55 244c-1.2-31.6 11.6-63.9 35.1-88.6 23.4-24.6 54.9-39 86.5-39.4 31.8-2.7 64.4 8.5 91.9 31.5 1 .8 1.6 2 1.6 3.2.1 1.3-.3 2.5-1.2 3.4-9.7 10.6-20.2 22-31.6 32.6-1.5 1.4-3.8 1.6-5.6.6-26.8-16.3-49.4-20.8-69.1-13.9-.1 0-.2.1-.3.1-18.4 5.2-34.2 18.8-43.5 37.2-9.2 18.2-10.6 38.8-3.9 56.5 0 .1.1.2.1.3 5.5 18.4 19.5 34 38.4 42.7 19.1 8.8 40.4 9.4 58.3 1.5.1 0 .2-.1.3-.1 15.8-5.6 28.4-19.3 35.3-37.9-8.4-.1-16.9-.2-25.2-.2-12.9-.1-26.3-.1-39.4-.5-2.5-.1-4.5-2.1-4.5-4.6-.1-15.6-.1-28.7-.1-42.1 0-2.5 2.1-4.6 4.6-4.6h7.6c10.8 0 21.7 0 32.5-.1 2 0 3.8 1.2 4.4 3.1 1 3.2-1.3 6.2-4.4 6.2-10.8 0-21.7 0-32.5.1h-3c0 10.5 0 21 .1 32.9 11.6.3 23.3.3 34.7.4 10.3.1 21 .1 31.6.3.6 0 1.2.1 1.7.4 2.3 1 3.2 3.4 2.6 5.6-7.1 24.4-22.8 42.5-42.9 49.8-20.3 8.9-44.3 8.3-65.8-1.6-21.2-9.8-37-27.4-43.3-48.3-7.5-20.1-6-43.3 4.3-63.8 10.4-20.7 28.3-35.9 49.1-41.9 21.7-7.6 45.8-3.4 73.8 12.9 8.9-8.5 17.3-17.4 25.2-26-24.8-19.4-53.7-28.7-81.6-26.3h-.3c-29.1.3-58.3 13.7-80 36.5-21.8 22.9-33.7 52.8-32.6 82v.3c-1 49.5 32.7 96.7 80.1 112.3 47.5 16 100.2 2 128.1-33.9l.1-.1c18.1-22.3 26.2-53 24.3-91.3-3.3 0-6.5 0-9.8-.1-2.2 0-4.3-1.5-4.7-3.7-.6-3 1.7-5.5 4.6-5.5 4.8 0 9.5.1 14.3.1 2.4 0 4.4 1.9 4.6 4.3 3 42.7-5.8 77-26 102-15.3 19.6-37.2 33.5-63.3 40-10.3 2.4-21.3 3.7-32.2 3.7zm78-141.2H249.3c-2.2 0-4.3-1.5-4.7-3.7-.6-3 1.7-5.6 4.5-5.6h13c3.1 0 5.4 3 4.4 6.2-.8 1.9-2.6 3.1-4.5 3.1z"/>
                            <g>
                                <path class="st3"
                                      d="M377.9 190.8H413c.1 11.8.2 23.5.2 35.3 11.7.1 23.5.2 35.3.2v35.2c-11.7.1-23.5.1-35.3.2-.1 11.8-.2 23.5-.2 35.3-11.7-.1-23.5 0-35.2 0-.1-11.8-.1-23.5-.2-35.3-11.7-.1-23.5-.2-35.3-.2v-35.2c11.7-.1 23.5-.1 35.3-.2 0-11.7.1-23.5.3-35.3z"/>
                                <path d="M377.8 301.6c-2.5 0-4.6-2-4.6-4.6-.1-6.4-.1-12.8-.1-19.2 0-3.9 0-7.7-.1-11.6-9.4-.1-19-.1-28.2-.2h-2.5c-2.6 0-4.6-2.1-4.6-4.6v-35.2c0-2.5 2.1-4.6 4.6-4.6 4.2 0 8.4-.1 12.6-.1 6 0 12.1-.1 18.1-.1.1-9 .1-18.9.3-30.7 0-2.5 2.1-4.6 4.6-4.6H413c2.6 0 4.6 2.1 4.6 4.6 0 8.3.1 16.6.2 24.9v5.8c9.5.1 19.6.1 30.7.2 2.5 0 4.6 2.1 4.6 4.6v35.2c0 2.6-2.1 4.6-4.6 4.6h-5.8c-8.3 0-16.6.1-24.9.1-.1 10.3-.1 20.7-.2 30.7 0 1.2-.5 2.4-1.4 3.3-.9.9-2.1 1.3-3.3 1.3h-23.5c-3.8.2-7.7.2-11.6.2zm-30.9-44.7c10.1 0 20.5.1 30.7.2 2.5 0 4.5 2.1 4.6 4.6 0 5.4.1 10.8.1 16.2 0 4.8 0 9.7.1 14.5h26c0-10.1.1-20.5.2-30.7 0-2.5 2.1-4.6 4.6-4.6 9.8-.1 19.7-.1 29.5-.2h1.2v-26c-11-.1-21.1-.1-30.7-.2-2.5 0-4.6-2.1-4.6-4.6l-.1-10.4c0-6.8-.1-13.5-.1-20.3h-25.9c-.1 11.8-.2 21.6-.2 30.7 0 2.5-2.1 4.6-4.6 4.6-7.6.1-15.2.1-22.7.2h-8l-.1 26z"/>
                            </g>
                        </svg>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>


<div class="sticky-navbar display-none"></div>

<div class="container-fluid home-wrapper home-wrapper home-wrapper-100">
    <!--  <div class="home-background-overlap"></div> -->

    <!-- Navigation -->
    <nav class="navbar navbar-home">
        <div class="container-fluid navbar-home-container no-tablet-padding">
            <div class="navbar-header">
                <button type="button" role="button" class="navbar__gamburger__icon / white / js-toggle-mobile-navbar"
                        aria-label="Toggle Navigation" aria-expanded="false">
                    <span class="lines"></span>
                </button>
                <a class="navbar-brand" href="{homepage_url_lang}"><img src="<?php echo $website_logo_url; ?>"
                                                                        alt="<?php echo $settings_websitetitle; ?>"
                                                                        class="logotype"></a>
            </div>
            <div class="navbar-right-block">
                <ul class="nav navbar-nav navbar-right">
                    <?php /*<li><a href="<?php echo site_url($lang_code.'/179/about');?>" class="white-colored">About</a></li>*/ ?>
                    {not_logged}
                    <?php if (config_db_item('property_subm_disabled') == FALSE): ?>
                        <li class="hide-when-login-register-opened">
                            <a href="#"
                               class="login-menu white-colored js-toggle-login-popup js-close-mobile-navbar">
                                <i class="fa fa-user-o" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="show-when-login-register-opened"><a href="#" class="js-close-login-register-popups"><div class="close-icon white"></div></a></li>
                    <!--<li><a href="{front_login_url}#content" id="page-popup-open-login" class="login-menu white-colored"><i class="fa fa-user-o" aria-hidden="true"></i> {lang_Myaccount}</a></li> -->
                    <?php endif; ?>
                    {/not_logged}

                    {is_logged_user}
                    <li class="logedin">
                        <a id="profile-img">
                            <?php if ($this->session->userdata('profile_image') != '' && file_exists(FCPATH . $this->session->userdata('profile_image'))): ?>
                                <img src="<?php echo base_url($this->session->userdata('profile_image')); ?>" alt="">
                            <?php else: ?>
                                <img src="assets/img/user-agent.png" alt="">
                            <?php endif; ?>
                        </a>
                        <div class="profile-box-wrapper display-none">
                            <div class="profile-box-img">
                                <?php if($this->session->userdata('profile_image') != '' && file_exists(FCPATH.$this->session->userdata('profile_image'))):?>
                                    <img src="<?php echo base_url($this->session->userdata('profile_image'));?>" alt="">
                                <?php else:?>
                                    <img src="assets/img/user-agent.png" alt="">
                                <?php endif;?>
                            </div>
                            <div class="profile-box-data">
                                <p id="profile-box-name"><?php echo $this->session->userdata('name_surname');?></p>
                                <!--<p class="small-font"><?php /*echo $this->session->userdata('username');*/?></p>-->
                                <p class="small-font">533 000 4703</p>
                                <a href="{login_url}">
                                    <button>{lang_Profile}</button>
                                </a>
                                <a href="{myprofile_url}#content"><i class="ion-ios-cog-outline"></i></a>
                            </div>
                            <div class="profile-box-bottom clearfix">
                                <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                                    <a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="standart-button">
                                        {lang_Add Event}
                                    </a>
                                <?php endif;?>
                                <a href="{logout_url}" class="standart-button">
                                    {lang_Sign out}
                                </a>
                            </div>
                        </div>
                    </li>
                    {/is_logged_user}
                    {is_logged_other}
                    <li class="logedin">
                        <a id="profile-img">
                            <?php if ($this->session->userdata('profile_image') != '' && file_exists(FCPATH . $this->session->userdata('profile_image'))): ?>
                                <img src="<?php echo base_url($this->session->userdata('profile_image')); ?>" alt="">
                            <?php else: ?>
                                <img src="assets/img/user-agent.png" alt="">
                            <?php endif; ?>
                        </a>
                        <div class="profile-box-wrapper display-none">
                            <div class="profile-box-img">
                                <?php if ($this->session->userdata('profile_image') != '' && file_exists(FCPATH . $this->session->userdata('profile_image'))): ?>
                                    <img src="<?php echo base_url($this->session->userdata('profile_image')); ?>"
                                         alt="">
                                <?php else: ?>
                                    <img src="assets/img/user-agent.png" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="profile-box-data">
                                <p id="profile-box-name"><?php echo $this->session->userdata('name_surname'); ?></p>
                                <p class="small-font"><?php echo $this->session->userdata('type'); ?></p>
                                <a href="{login_url}">
                                    <button><?php echo lang_check('Account'); ?></button>
                                </a>
                                <a href="{myprofile_url}#content"><i class="ion-ios-cog-outline"></i></a>
                            </div>
                            <div class="profile-box-bottom clearfix">
                                <?php if (config_db_item('property_subm_disabled') == FALSE): ?>
                                    <a href="<?php echo site_url('admin/estate/edit'); ?>" class="standart-button">
                                        <?php echo lang_check('Add Event'); ?>
                                    </a>
                                <?php endif; ?>
                                <a href="{logout_url}" class="standart-button">
                                    {lang_Logout}
                                </a>
                            </div>
                        </div>
                    </li>
                    {/is_logged_other}
                </ul>
            </div>
        </div>
    </nav>


    <div class="home__header__bg__wrap">
        <div class="home__header__bg" style="background-image: url('assets/img/home/exploreeveryday_181k_mirrored.jpg')"></div>
    </div>

    <div class="home__header__overlay"></div>

    <!-- Search container -->
    <div class="main-home-container / js-hide-when-navbar-open js-hide-when-login-open">
        <div class="home-container-content-wrapper">
            <?php /* <h4 class="container-header"><?php echo lang_check('Welcome to UDORA');?></h4> */?>
            <h2><?php echo lang_check('Find your next experience');?></h2>
            <?php _widget('custom_center_search');?>
            <div class="col-xs-12">
                <h5><?php echo lang_check('100M+ Events  |  30,000 Cities  |  4M Explorers');?></h5>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <!-- <a href="" class="scroll-button"><i class="material-icons">&#xE5CF;</i></a> -->
</div>

<script>

    $('document').ready(function () {

        $('form#popup_form_login').submit(function (e) {
            e.preventDefault();
            var data = $('form#popup_form_login').serializeArray();
            //console.log( data );
            $('form#popup_form_login .ajax-indicator').removeClass('hidden');
            // send info to agent
            $.post("<?php echo site_url('api/login_form/' . $lang_code); ?>", data,
                function (data) {
                    if (data.success) {
                        // Display agent details
                        $('form#popup_form_login .alerts-box').html('');
                        if (data.message) {
                            ShowStatus.show(data.message)
                        }
                        if (data.redirect) {
                            location.href = data.redirect;
                        }
                        /*location.reload();*/
                    }
                    else {
                        if (data.message) {
                            ShowStatus.show(data.message)
                        }
                        $('form#popup_form_login .alerts-box').html(data.errors);
                    }
                }).success(function () {
                $('form#popup_form_login .ajax-indicator').addClass('hidden');
            });
            return false;
        });


        $('form#popup_form_register').submit(function (e) {
            e.preventDefault();
            var data = $('form#popup_form_register').serializeArray();
            //console.log( data );
            $('form#popup_form_register .ajax-indicator').removeClass('hidden');
            // send info to agent
            $.post("<?php echo site_url('api/register_form/' . $lang_code); ?>", data,
                function (data) {
                    if (data.success) {
                        // Display agent details
                        var dalay = 2000;
                        $('#popup_form_register .alerts-box').html('');
                        if (data.message) {
                            ShowStatus.show(data.message)
                        }
                        if (data.redirect) {
                            location.href = data.redirect;
                        } else {
                            dalay = 5000;
                        }

                        setTimeout(function () {
                            location.reload()
                        }, dalay);
                    }
                    else {
                        if (data.message) {
                            ShowStatus.show(data.message)
                        }
                        $('form#popup_form_register .alerts-box').html(data.errors);
                    }
                }).success(function () {
                $('form#popup_form_register .ajax-indicator').addClass('hidden');
            });
            return false;
        });


        var isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
        if (!isFirefox) {
            $(".home-wrapper input").on('focus', function () {
                $('.home__header__bg').addClass('is-blurred');

            }).on('focusout', function () {
                $('.home__header__bg').removeClass('is-blurred');
            });
        }


    })


</script>
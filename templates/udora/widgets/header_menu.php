<?php
/*
Widget-title: Header bar (logo, search, menu)
Widget-preview-image: /assets/img/widgets_preview/header_menu.jpg
*/
?>
<?php
// get user ip
$ip = $_SERVER['REMOTE_ADDR'];
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
// if($query && $query['status'] == 'success') 
?>

<?php
$CI = &get_instance();
if(!isset($login_url_facebook)){
$login_url_facebook = '';
    if($CI->config->item('facebook_api_version') == '2.4' || floatval($this->config->item('facebook_api_version')) >= 2.4
          || version_compare($CI->config->item('facebook_api_version'), 2.4, '>') 
        )
    {
        $user_facebook = FALSE;
        if($CI->config->item('appId') != '')
        {   
            $CI->load->library('facebook/Facebook'); // Automatically picks appId and secret from config
            $user_facebook = $CI->facebook->getUser();
        }
        if ($user_facebook) {
        } else if($CI->config->item('appId') != ''){
            $login_url_facebook = $CI->facebook->login_url();
        }
    }
    else
    {
        $user_facebook = FALSE;
        if($CI->config->item('appId') != '')
        {
            $CI->load->library('facebook'); // Automatically picks appId and secret from config
            $user_facebook = $CI->facebook->getUser();
        }   
        $login_url_facebook = '';
        if ($user_facebook) {
        } else if($CI->config->item('appId') != ''){
            $login_url_facebook = $CI->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('frontend/login/'.$this->data['lang_code']), 
                'scope' => array("email") // permissions here
            ));
        }
    }

}
?>

<?php
/* $enquire_3 add image of profile */

/*
 * function for array_walk();
 * add in $enquire_3 profile image for user message
 * 
 * use array_walk($enquire_3, 'add_profile_image');
 */
$CI = & get_instance();
$CI->load->model('enquire_m');
$enquire_3= $CI->enquire_m->get_by(NULL, FALSE, 3, 'enquire.id DESC');
function add_profile_image(&$item, $key) {
    $CI = & get_instance();
    if (!empty($item->filename) and file_exists(FCPATH . '/files/' . $item->filename)) {
        $profile_image = base_url('/files/' . $item->filename);
    } else {
        $profile_image = 'assets/img/user-agent.png';
    }
    $item->profile_image = $profile_image;
}

array_walk($enquire_3, 'add_profile_image');
/* end $enquire_3 add image of profile */
?>


<div class="page-popup-wrapper left-menu-wrapper page-login js-popup-login">
    <div class="left-menu py-1 px-1 py-sm-6 px-sm-2">
            <div class="login-form login-on-page" id="login-modal">
                <div class="col-xs-12">
                    <h3 class="text-center / mb-1"><?php echo lang_check('Welcome to Udora'); ?></h3>
                </div>                           
                <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id'=>'popup_form_login')) ?>
                <div class="d-none d-md-block close-modal"><div class="close-icon js-toggle-login-popup black"></div></div>
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
                    <a class="button-login-inv js-toggle-register-popup" href="#"><?php echo lang_check('Sign Up');?></a>
                    <a class="link_forg" href="<?php echo site_url('admin/user/forgetpassword'); ?>"><?php echo lang_check('Forget password?') ?></a>
                </div>
            </div> 
    </div>
</div>
<!-- *************************** Check in Modal window ******************************* -->
 <div class="modal fade mt-2" id="checkin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="w-100 d-flex justify-content-center align-items-center" style="height: 100%;">
        <div class="checkin_modal_wrap w-100 p-2">
            <div class="close_icon_wraper ">
                <i class="material-icons close_checkin_modal"  data-dismiss="modal">close</i>
            </div>
            <form action="<?php echo site_url('api/popup_request_to_event/'.$lang_code); ?>" enctype="multipart/form-data">
                <h4 class="text-center">Check in</h4>
                <div class="text-center">
                    <label for="checkin_file-upload" class=" d-flex justify-content-center align-items-center mx-auto">
                        <span class="camera_icon_checkin d-flex justify-content-center align-items-center mx-auto" >
                            <i class="material-icons">photo_camera</i>
                        </span>                    
                    </label>
                    <p class="checkin_file_name"></p>
                    <input id="checkin_file-upload" name="qr_code" class="d-none" type="file"/>
                    <div class="text-center p-1">
                        Tap the icon to scan event code or enter the code in the space below
                    </div>
                    <script type="text/javascript">
                            $(document).ready(function(){
                                $('input[type="file"]#checkin_file-upload').change(function(e){
                                    var fileName = e.target.files[0].name;
                                    $('.checkin_file_name').text(fileName);
                                });
                            });
                    </script>                
                </div>
                <div class="d-flex justify-content-around mb-3">
                    <input class="checkin_short_number" type="text" pattern="\d*" maxlength="1" size="1" name="key_1">
                    <input class="checkin_short_number" type="text" pattern="\d*" maxlength="1" size="1" name="key_2">
                    <input class="checkin_short_number" type="text" pattern="\d*" maxlength="1" size="1" name="key_3">
                    <input class="checkin_short_number" type="text" pattern="\d*" maxlength="1" size="1" name="key_4">
                </div>
                <div class="p-1">
                    <input class="btn btn-udora w-100" type="submit" name="" value="Submit">               
                </div>
            </form>        
        </div>
    </div>
</div>

<div class="page-popup-wrapper left-menu-wrapper page-register js-register-popup">
    <div class="left-menu py-1 px-1 py-sm-6 px-sm-2">
        <div class="d-none d-md-block close-modal"><div class="close-icon black js-toggle-register-popup"></div></div>
            <div class="col-xs-12 col-md-12 border-create-account">
                <div class="login-form create-account-form create-account-page">
                    <div class="col-xs-12">
                        <h3 class="text-center / mb-1"><?php echo lang_check('Welcome to Udora'); ?></h3>
                    </div>                           
                    <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id'=>'popup_form_register')) ?>
                    <div class="d-none d-md-block close-modal"><div class="close-icon js-toggle-login-popup black"></div></div>
                    <div class="col-xs-12 alerts-box">
                    </div>
                    <div class="login-inputs col-xs-12 flabel-anim">
                        <?php if (config_db_item('register_reduced') == FALSE): ?>
                            <div class="form-group">
                               <?php echo form_input('username', set_value('username', ''), 'class="w-100 form-control" id="inputUsername2" placeholder="' . lang('Username') . '"') ?>
                               <label><?php echo lang_check("Username");?></label>
                           </div>
                        <?php endif; ?>
                        
                        <div class="form-group">
                           <?php echo form_input('name_surname', set_value('name_surname', ''), 'class="col-xs-12 col-lg-12 form-control" id="inputNameSurname" placeholder="' . lang('FirstLast') . '"') ?>
                           <label><?php echo lang_check("FirstLast");?></label>
                        </div>
                       
                        <div class="form-group">
                           <?php echo form_input('mail', set_value('mail', ''), 'class="w-100 form-control" id="inputMail" placeholder="' . lang('Email') . '"') ?>
                           <label><?php echo lang_check("Email");?></label>
                       </div>
                        <div class="form-group">
                            <?php echo form_password('password', set_value('password', ''), 'class="w-100 form-control" id="inputPassword2" placeholder="' . lang('Password') . '" autocomplete="off"') ?>
                           <label><?php echo lang_check("Password");?></label>
                       </div>
                        <?php echo form_password('password_confirm', 'auto', 'class="form-control hidden" id="inputPasswordConfirm" placeholder="' . lang('Confirmpassword') . '" autocomplete="off"') ?>
                        <div class="hint-box form-group">
                            <?php echo form_input('age', set_value('age', ''), 'class="w-100" id="inputAge" placeholder="' . lang_check('Age') . '"') ?>
                            <span class="hintlabewl hint--top-left"
                                  aria-label="<?php echo lang_check('To sign up you must be 13 or older. Other people won\'t see your birthday'); ?>"><i
                                        class="fa fa-question" aria-hidden="true"></i></span>
                        </div>
                        <div class="clearfix text-left mb-1 mb-sm-2">
                            <label class="login-checkbox">
                            <?php echo form_radio('gender','male', '', 'class="inputGender"') ?> <?php echo lang_check('Male');?>
                            </label>
                            <label class="login-checkbox">
                            <?php echo form_radio('gender','female', '', 'class="inputGender"') ?> <?php echo lang_check('Female');?>
                            </label>
                            <label class="login-checkbox">
                            <?php echo form_radio('gender','custom', '', 'class="inputGender"') ?> <?php echo lang_check('Custom');?>
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
                    <div class="col-xs-12 mb-2 mb-sm-3">
                        <button class="button-login col-xs-12 col-lg-12" type="submit"><?php echo lang_check('Join Now');?>
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
                        <?php echo lang_check('Already have a Udora acccount?');?>
                        <a class="js-toggle-login-popup button-login-inv" href="#"><?php echo lang_check('Sign In');?></a>
                    </div>
                </div>
            </div>
    </div>
</div>



<nav class="mobile-menu d-flex flex-column align-items-start" id="js-mobile-menu">
        <button type="button" role="button" class="navbar__gamburger__icon / white / js-toggle-mobile-navbar x" aria-label="Toggle Navigation" aria-expanded="false">
            <span class="lines"></span>
        </button>
        <a class="mobile-menu_black_logo" href="{homepage_url_lang}"><img src="assets/img/white_udora_logo.svg" 
                                                                          alt="<?php echo $settings_websitetitle; ?>" 
                                                                          class="logotype"></a>
        <div class="mobile-menu-user-info">
            <?php if($this->session->userdata('profile_image') != '' && file_exists(FCPATH.$this->session->userdata('profile_image'))):?>
                <div  class="activities_user_foto" style="background-image: url('<?php echo base_url($this->session->userdata('profile_image'));?>');"></div>
            <?php else:?>
                <div  class="activities_user_foto" style="background-image: url('assets/img/user-agent.png');"></div>
            <?php endif;?>

            <h4><?php echo $this->session->userdata('name_surname');?></h4>
            
        </div>
    <ul class="mobile-menu__links">

        <li class="mobile-menu__links__item"><a
                    href="<?php echo site_url($lang_code); ?>"><i class="material-icons">remove_red_eye</i><?php echo lang_check('Explore'); ?></a></li>
        <li class="mobile-menu__links__item"><a
                    href="<?php echo site_url($lang_code . '/179/blog_page'); ?>"><i class="material-icons">history</i><?php echo lang_check('About'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/6/map'); ?>"><i class="material-icons">location_on</i><?php echo lang_check('Map'); ?></a>
        </li>
        {is_logged_user}
           <hr>
            <li class="mobile-menu__links__item">
                <a href="{myproperties_url}#content"><i class="material-icons">dashboard</i><?php echo lang_check('Dashboard'); ?></a>
            </li>
            <li class="mobile-menu__links__item">
                <a href="{myprofile_url}#content"><i class="material-icons">person</i><?php echo lang_check('My Profile'); ?></a>
            </li>
            <li class="mobile-menu__links__item">
                <a href="<?php echo site_url('frontend/editproperty/' . $lang_code . '#content'); ?>"><i class="material-icons">playlist_add</i><?php echo lang_check('Add Events'); ?></a>
            </li>
            <li class="mobile-menu__links__item">
                <a href="{myfavorites_url}#content"><i class="material-icons">favorite</i><?php echo lang_check('Saved Events'); ?></a>
            </li>
            <li class="mobile-menu__links__item">
                <a href="<?php echo site_url('frontend/notificationsettings/' . $lang_code . '#content'); ?>"><i class="material-icons">notifications_active</i><?php echo lang_check('Notifications'); ?></a>
            </li>
            <hr>
        {/is_logged_user}

        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/142/blog_page'); ?>"><i class="material-icons">book</i><?php echo lang_check('Blog'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/147/featured'); ?>"><i class="material-icons">link</i><?php echo lang_check('Featured'); ?></a>
        </li>
        {not_logged}
        <div class="mobile-menu_user_location">
            <p class="mobile_location-description">Estimated location</p>
            <p class="mobile-menu__links__item"><i class="material-icons">my_location</i>Location <?php echo _ch($query['city']); ?></p>
            <p class="mobile_location-description">Search Radius 50km / 31 miles</p>
        </div>
        {/not_logged}
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/180/organizer/'); ?>"><i class="material-icons">work</i><?php echo lang_check('Organizer'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/182/terms_of_service'); ?>"><i class="material-icons">lock</i><?php echo lang_check('Terms & Privacy'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="https://udora.io/support/"><i class="material-icons">help</i><?php echo lang_check('Help'); ?></a>
        </li>
        <li class="mobile-menu__links__item">
            <a href="<?php echo site_url($lang_code . '/4/contact'); ?>"><i class="material-icons">call</i><?php echo lang_check('Contact'); ?></a>
        </li>

    </ul>
    <div class="mobile-menu_bottom_info">
        <div class="mobile-menu_bottom_info_version">
            <h4>Udora Events</h4>
            <h5>Version 1.0</h5>            
        </div>
        <ul class="mobile-menu__links__item__social">
                <li>
                    <a href="https://www.facebook.com/share.php?u=https://udora.io/production/&amp;title=Udora"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">

                       <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                            viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
                             xml:space="preserve">
                                <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                                    C49.652,11.137,38.516,0,24.826,0z M31,25.7h-4.039c0,6.453,0,14.396,0,14.396h-5.985c0,0,0-7.866,0-14.396h-2.845v-5.088h2.845
                                    v-3.291c0-2.357,1.12-6.04,6.04-6.04l4.435,0.017v4.939c0,0-2.695,0-3.219,0c-0.524,0-1.269,0.262-1.269,1.386v2.99h4.56L31,25.7z
                                    "/>                            
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/home?status=Udora%20https://udora.io/production/"
                       onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                       <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;" xml:space="preserve">
                            <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                                    C49.652,11.137,38.516,0,24.826,0z M35.901,19.144c0.011,0.246,0.017,0.494,0.017,0.742c0,7.551-5.746,16.255-16.259,16.255
                                    c-3.227,0-6.231-0.943-8.759-2.565c0.447,0.053,0.902,0.08,1.363,0.08c2.678,0,5.141-0.914,7.097-2.446c-2.5-0.046-4.611-1.698-5.338-3.969c0.348,0.066,0.707,0.103,1.074,0.103c0.521,0,1.027-0.068,1.506-0.199c-2.614-0.524-4.583-2.833-4.583-5.603c0-0.024,0-0.049,0.001-0.072c0.77,0.427,1.651,0.685,2.587,0.714c-1.532-1.023-2.541-2.773-2.541-4.755c0-1.048,0.281-2.03,0.773-2.874c2.817,3.458,7.029,5.732,11.777,5.972c-0.098-0.419-0.147-0.854-0.147-1.303c0-3.155,2.558-5.714,5.713-5.714c1.644,0,3.127,0.694,4.171,1.804c1.303-0.256,2.523-0.73,3.63-1.387c-0.43,1.335-1.333,2.454-2.516,3.162c1.157-0.138,2.261-0.444,3.282-0.899C37.987,17.334,37.018,18.341,35.901,19.144z"/>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="https://www.youtube.com">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"     width="97.75px" height="97.75px" viewBox="0 0 97.75 97.75" style="enable-background:new 0 0 97.75 97.75;" xml:space="preserve">

                                <polygon points="25.676,52.482 29.551,52.482 29.551,73.455 33.217,73.455 33.217,52.482 37.164,52.482 37.164,49.047 
                                    25.676,49.047       "/>
                                <path d="M56.674,55.046c-1.212,0-2.343,0.662-3.406,1.972v-7.972h-3.295v24.409h3.295v-1.762c1.103,1.361,2.233,2.013,3.406,2.013
                                    c1.311,0,2.193-0.69,2.633-2.044c0.221-0.771,0.334-1.982,0.334-3.665v-7.242c0-1.722-0.113-2.924-0.334-3.655
                                    C58.868,55.736,57.984,55.046,56.674,55.046z M56.344,68.255c0,1.644-0.482,2.454-1.434,2.454c-0.541,0-1.092-0.259-1.643-0.811
                                    V58.814c0.551-0.545,1.102-0.803,1.643-0.803c0.951,0,1.434,0.842,1.434,2.482V68.255z"/>
                                <path d="M43.824,69.167c-0.731,1.033-1.422,1.542-2.084,1.542c-0.44,0-0.691-0.259-0.771-0.771c-0.03-0.106-0.03-0.508-0.03-1.28
                                    v-13.39h-3.296v14.379c0,1.285,0.111,2.153,0.291,2.705c0.331,0.922,1.063,1.354,2.123,1.354c1.213,0,2.457-0.732,3.767-2.234
                                    v1.984h3.298V55.268h-3.298V69.167z"/>
                                <path d="M46.653,38.466c1.073,0,1.588-0.851,1.588-2.551v-7.731c0-1.701-0.515-2.548-1.588-2.548c-1.074,0-1.59,0.848-1.59,2.548
                                    v7.731C45.063,37.616,45.579,38.466,46.653,38.466z"/>
                                <path d="M48.875,0C21.882,0,0,21.882,0,48.875S21.882,97.75,48.875,97.75S97.75,75.868,97.75,48.875S75.868,0,48.875,0z
                                     M54.311,22.86h3.321v13.532c0,0.781,0,1.186,0.04,1.295c0.073,0.516,0.335,0.78,0.781,0.78c0.666,0,1.365-0.516,2.104-1.559
                                    V22.86h3.33v18.379h-3.33v-2.004c-1.326,1.52-2.59,2.257-3.805,2.257c-1.072,0-1.812-0.435-2.146-1.365
                                    c-0.184-0.557-0.295-1.436-0.295-2.733V22.86L54.311,22.86z M41.733,28.853c0-1.965,0.334-3.401,1.042-4.33
                                    c0.921-1.257,2.218-1.885,3.878-1.885c1.668,0,2.964,0.628,3.885,1.885c0.698,0.928,1.032,2.365,1.032,4.33v6.436
                                    c0,1.954-0.334,3.403-1.032,4.322c-0.921,1.254-2.217,1.881-3.885,1.881c-1.66,0-2.957-0.627-3.878-1.881
                                    c-0.708-0.919-1.042-2.369-1.042-4.322V28.853z M32.827,16.576l2.622,9.685l2.519-9.685h3.735L37.26,31.251v9.989h-3.692v-9.989
                                    c-0.335-1.77-1.074-4.363-2.259-7.803c-0.778-2.289-1.589-4.585-2.367-6.872H32.827z M75.186,75.061
                                    c-0.668,2.899-3.039,5.039-5.894,5.358c-6.763,0.755-13.604,0.759-20.42,0.755c-6.813,0.004-13.658,0-20.419-0.755
                                    c-2.855-0.319-5.227-2.458-5.893-5.358c-0.951-4.129-0.951-8.638-0.951-12.89s0.012-8.76,0.962-12.89
                                    c0.667-2.9,3.037-5.04,5.892-5.358c6.762-0.755,13.606-0.759,20.421-0.755c6.813-0.004,13.657,0,20.419,0.755
                                    c2.855,0.319,5.227,2.458,5.896,5.358c0.948,4.13,0.942,8.638,0.942,12.89S76.137,70.932,75.186,75.061z"/>
                                <path d="M67.17,55.046c-1.686,0-2.995,0.619-3.947,1.864c-0.699,0.92-1.018,2.342-1.018,4.285v6.371
                                    c0,1.933,0.357,3.365,1.059,4.276c0.951,1.242,2.264,1.863,3.988,1.863c1.721,0,3.072-0.651,3.984-1.972
                                    c0.4-0.584,0.66-1.245,0.77-1.975c0.031-0.33,0.07-1.061,0.07-2.124v-0.479h-3.361c0,1.32-0.043,2.053-0.072,2.232
                                    c-0.188,0.881-0.662,1.321-1.473,1.321c-1.132,0-1.686-0.84-1.686-2.522v-3.226h6.592v-3.767c0-1.943-0.329-3.365-1.02-4.285
                                    C70.135,55.666,68.824,55.046,67.17,55.046z M68.782,62.218h-3.296v-1.683c0-1.682,0.553-2.523,1.654-2.523
                                    c1.09,0,1.642,0.842,1.642,2.523V62.218z"/>                            
                        </svg>
                    </a>
                </li>
            </ul>
        
    </div>
    
</nav>


<nav class="navbar white-nav sticky-navbar main-navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" role="button" class="navbar__gamburger__icon / black / js-toggle-mobile-navbar" aria-label="Toggle Navigation" aria-expanded="false">
                <span class="lines"></span>
            </button>
            <a class="navbar-brand" href="{homepage_url_lang}"><img src="assets/img/udora-logo-color.svg" class="logotype" alt=""></a>
        </div>
<!--         <form class="navbar-form navbar-left navigation-search-form search-form-mini" role="search">
            <div class="line">
            </div>
            <button type="submit" class="btn btn-default navigation-search-submit search"><i class="ion-search"></i></button>
            <div class="form-group search-wrapper">
                <input type="text" class="form-control navigation-search" id="quickly_search" placeholder="<?php echo lang_check('Search');?>...">
            </div>
        </form> -->
            <?php
               if ( ! function_exists('get_menu_custom'))
               {
               //menu generate function
               function get_menu_custom ($array, $child = FALSE, $lang_code)
               {
                       $CI =& get_instance();
                       $str = '';

                   $is_logged_user = ($CI->user_m->loggedin() == TRUE);

                       if (count($array)) {
                           $str .= $child == FALSE ? '<ul class="nav navbar-nav navbar-right" role="navigation">' . PHP_EOL : '<ul class="dropdown-menu">' . PHP_EOL;
                                               $position = 0;
                               foreach ($array as $key=>$item) {
                                       $position++;

                           $active = $CI->uri->segment(2) == url_title_cro($item['id'], '-', TRUE) ? TRUE : FALSE;

                           if($position == 1 && $child == FALSE){
                               //$item['navigation_title'] = '<img src="assets/img/home-icon.png" alt="'.$item['navigation_title'].'" />';

                               if($CI->uri->segment(2) == '')
                                   $active = TRUE;
                           }

                           if($item['is_visible'] == '1')
                           if(empty($item['is_private']) || $item['is_private'] == '1' && $is_logged_user)
                                       if (isset($item['children']) && count($item['children'])) {

                               $href = slug_url($lang_code.'/'.$item['id'].'/'.url_title_cro($item['navigation_title'], '-', TRUE), 'page_m');
                               if(substr($item['keywords'],0,4) == 'http')
                                   $href = $item['keywords'];
                                   
                               if(substr($item['keywords'],0,6) == 'search')
                               {
                                    $href = $href.'?'.$item['keywords'];
                                    $href = str_replace('"', '%22', $href);
                               }
                               
                                $target = '';
                                if(substr($item['keywords'],0,4) == 'http')
                                {
                                    $href = $item['keywords'];
                                    if(substr($item['keywords'],0,10) != substr(site_url(),0,10))
                                    {
                                        $target=' target="_blank"';
                                    }
                                }
                                   
                               if($item['keywords'] == '#')
                                   $href = '#';

                                               $str .= $active ? '<li class="dropdown active">' : '<li class="dropdown">';
                                               $str .= '<a href="' . $href . '" class="dropdown-toggle dark-link hidden-sm hidden-xs" data-toggle="dropdown" '.$target.'>' . $item['navigation_title'];
                                               $str .= ' <span class="caret"></span></a>' . PHP_EOL;

                                               $str .= get_menu_custom($item['children'], TRUE, $lang_code);
                                       }
                                       else {

                               $href = slug_url($lang_code.'/'.$item['id'].'/'.url_title_cro($item['navigation_title'], '-', TRUE), 'page_m');
                               if(substr($item['keywords'],0,4) == 'http')
                                   $href = $item['keywords'];
                                   
                               if(substr($item['keywords'],0,6) == 'search')
                               {
                                    $href = $href.'?'.$item['keywords'];
                                    $href = str_replace('"', '%22', $href);
                               }
                               
                                $target = '';
                                if(substr($item['keywords'],0,4) == 'http')
                                {
                                    $href = $item['keywords'];
                                    if(substr($item['keywords'],0,10) != substr(site_url(),0,10))
                                    {
                                        $target=' target="_blank"';
                                    }
                                }

                               if($item['keywords'] == '#')
                                   $href = '#';

                                               $str .= $active ? '<li class="active">' : '<li>';
                                               $str .= '<a href="' . $href . '" '.$target.' class="dark-link hidden-sm hidden-xs">' . $item['navigation_title'] . '</a>';

                                       }
                                       $str .= '</li>' . PHP_EOL;
                               }

                               $str .= '</ul>' . PHP_EOL;
                       }

                       return $str;
               }
               }
               ?>

        <a class="navbar-brand-mobile" href="{homepage_url_lang}">
            <img src="assets/img/udora-logo-color.svg" class="logotype pr" alt="">
            <img src="assets/img/udora-logo.svg" class="logotype sec" alt="">
        </a>
        
        
        <div class="navbar-right-block">
        <?php
           $CI =& get_instance();
           echo get_menu_custom($CI->temp_data['menu'], FALSE, $lang_code);
       ?>
        <ul class="nav navbar-nav navbar-right">
            <?php if(isset($page_id) && $page_id == 6):?>
             <li class="d-block d-md-none">
                    <a href="" class="switch_res_list_btn_header">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="30px" height="20px" viewBox="0 0 60 40" style="enable-background:new 0 0 40 40;"
                             xml:space="preserve">
                            <path d="M4,5h45" stroke="#000" stroke-width="6px" fill="none" stroke-dasharray="6,4,38,20"/> 
                            <path d="M4,20h45" stroke="#000" stroke-width="6px" fill="none" stroke-dasharray="6,4,38,20"/> 
                            <path d="M4,35h45" stroke="#000" stroke-width="6px" fill="none" stroke-dasharray="6,4,38,20"/>                            
                        </svg>
                    </a>
                </li>
                <li class="d-block d-md-none switch_res_map_header pl-2 pr-2">
                    <a href="" class="switch_res_map_btn_header">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="20px" height="20px" viewBox="0 0 491.582 491.582" style="enable-background:new 0 0 491.582 491.582;"
                             xml:space="preserve">
                            <g class="header_map_pointer">
                                <path d="M245.791,0C153.799,0,78.957,74.841,78.957,166.833c0,36.967,21.764,93.187,68.493,176.926
                                    c31.887,57.138,63.627,105.4,64.966,107.433l22.941,34.773c2.313,3.507,6.232,5.617,10.434,5.617s8.121-2.11,10.434-5.617
                                    l22.94-34.771c1.326-2.01,32.835-49.855,64.967-107.435c46.729-83.735,68.493-139.955,68.493-176.926
                                    C412.625,74.841,337.783,0,245.791,0z M322.302,331.576c-31.685,56.775-62.696,103.869-64.003,105.848l-12.508,18.959
                                    l-12.504-18.954c-1.314-1.995-32.563-49.511-64.007-105.853c-43.345-77.676-65.323-133.104-65.323-164.743
                                    C103.957,88.626,167.583,25,245.791,25s141.834,63.626,141.834,141.833C387.625,198.476,365.647,253.902,322.302,331.576z"/>
                                <path d="M245.791,73.291c-51.005,0-92.5,41.496-92.5,92.5s41.495,92.5,92.5,92.5s92.5-41.496,92.5-92.5
                                    S296.796,73.291,245.791,73.291z M245.791,233.291c-37.22,0-67.5-30.28-67.5-67.5s30.28-67.5,67.5-67.5
                                    c37.221,0,67.5,30.28,67.5,67.5S283.012,233.291,245.791,233.291z"/>
                            </g>
                            
                        </svg>
                    </a>
                </li>
                <li class="d-sm-none pl-0 pr-0 pl-md-2 pr-md-2">
                    <a type="button" href="#" class="searchform-toggle hidden" data-toggle="collapse"><i class="ion-ios-search-strong"></i></a>
                </li>
                <?php endif;?>
                
                <li class="d-none d-md-flex"><a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="login-menu dark-link btn-submitevent">
                    <span><?php echo lang_check(' Add Event');?></span>
                    </a>
                </li>
                    {not_logged}
                        <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                            <li class="d-none d-md-flex">
                                <a href="{front_login_url}#content" class="js-toggle-login-popup dark-link udora-hover">
                                    <i class="fa fa-user-o" aria-hidden="true"></i>
                                    <span class="login-menu-item hidden-xs"><?php echo lang_check('Log in');?></span>
                                </a>
                            </li>
                            <li class="d-md-none hide-when-login-register-opened">
                                <a href="{front_login_url}#content" class="js-toggle-login-popup dark-link udora-hover">
                                    <i class="fa fa-user-o" aria-hidden="true"></i>
                                    <span class="login-menu-item hidden-xs"><?php echo lang_check('Log in');?></span>
                                </a>
                            </li>
                            <li class="d-md-none show-when-login-register-opened"><a href="#" class="js-close-login-register-popups"><div class="close-icon black"></div></a></li>
                        <?php endif;?>
                    {/not_logged}

                
                {is_logged_user}                                
                 <li role="presentation" class="dropdown notification-label js-hide-on-map-page">
                    <a href="#" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-bell"></i>
                        <?php if(!empty($enquire_3)):?>
                        <span class="badge"><?php echo count($enquire_3);?></span>
                        <?php endif;?>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($enquire_3 as $enquire): ?>
                            <li>
                                <a href="<?php echo site_url('admin/enquire/edit/' . $enquire->id); ?>">
                                    <span class="image"><img src="<?php echo $enquire->profile_image; ?>" alt="Profile Image" /></span>
                                    <span>
                                        <span><?php echo $enquire->name_surname; ?></span>
                                        <span class="time"><?php echo $enquire->date; ?></span>
                                    </span>
                                    <span class="message">
                                        <?php echo word_limiter(strip_tags($enquire->message), 25); ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>    
                        <li class="footer">
                            <div class="text-center">
                                <a href="<?php echo site_url('frontend/myproperties') ?>">
                                    <strong><?php echo lang_check('View All'); ?></strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                    
                <li class="logedin">
                    <a id="profile-img">
                        <?php if($this->session->userdata('profile_image') != '' && file_exists(FCPATH.$this->session->userdata('profile_image'))):?>
                        <img src="<?php echo base_url($this->session->userdata('profile_image'));?>" alt="">
                        <?php else:?>
                        <img src="assets/img/user-agent.png" alt="">
                        <?php endif;?>
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
                <li role="presentation" class="dropdown notification-label js-hide-on-map-page">
                    <a href="#" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-bell"></i>
                        <?php if(!empty($enquire_3)):?>
                        <span class="badge"><?php echo count($enquire_3);?></span>
                        <?php endif;?>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($enquire_3 as $enquire): ?>
                            <li>
                                <a href="<?php echo site_url('admin/enquire/edit/' . $enquire->id); ?>">
                                    <span class="image"><img src="<?php echo $enquire->profile_image; ?>" alt="Profile Image" /></span>
                                    <span>
                                        <span><?php echo $enquire->name_surname; ?></span>
                                        <span class="time"><?php echo $enquire->date; ?></span>
                                    </span>
                                    <span class="message">
                                        <?php echo word_limiter(strip_tags($enquire->message), 25); ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>    
                        <li class="footer">
                            <div class="text-center">
                                <a href="<?php echo site_url('admin/enquire') ?>">
                                    <strong><?php echo lang_check('View All'); ?></strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="logedin">
                    <a id="profile-img">
                        <?php if($this->session->userdata('profile_image') != '' && file_exists(FCPATH.$this->session->userdata('profile_image'))):?>
                        <img src="<?php echo base_url($this->session->userdata('profile_image'));?>" alt="">
                        <?php else:?>
                        <img src="assets/img/user-agent.png" alt="">
                        <?php endif;?>
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
                            <p class="small-font"><?php echo $this->session->userdata('type');?></p>
                            <a href="{login_url}">
                                <button><?php echo lang_check('Account');?></button>
                            </a>
                            <a href="{myprofile_url}#content"><i class="ion-ios-cog-outline"></i></a>
                        </div>
                        <div class="profile-box-bottom clearfix">
                            <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                            <a href="<?php echo site_url('admin/estate/edit/');?>" class="standart-button">
                                <?php echo lang_check('Add Event');?>
                            </a>
                            <?php endif;?>
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



<script>

$('document').ready(function(){

    if ((window.location.href).indexOf('map') > 0) {
        $('.js-hide-on-map-page').hide();
    }
    
    $('form#popup_form_login').submit(function(e){
        e.preventDefault();
        var data = $('form#popup_form_login').serializeArray();
        //console.log( data );
        $('form#popup_form_login .ajax-indicator').removeClass('hidden');
        // send info to agent
        $.post("<?php echo site_url('api/login_form/'.$lang_code); ?>", data,
        function(data){
            if(data.success)
            {
                // Display agent details
                $('form#popup_form_login .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                if(data.redirect) {
                    location.href = data.redirect;
                }
                /*location.reload();*/
            }
            else
            { 
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('form#popup_form_login .alerts-box').html(data.errors);
            }
        }).success(function(){$('form#popup_form_login .ajax-indicator').addClass('hidden');});
        return false;
    });
    
    
    $('form#popup_form_register').submit(function(e){
        e.preventDefault();
        var data = $('form#popup_form_register').serializeArray();
        //console.log( data );
        $('form#popup_form_register .ajax-indicator').removeClass('hidden');
        // send info to agent
        $.post("<?php echo site_url('api/register_form/'.$lang_code); ?>", data,
        function(data){
            if(data.success)
            {
                // Display agent details
                                var dalay = 2000;
                $('#popup_form_register .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                if(data.redirect) {
                    location.href = data.redirect;
                } else {
                                        dalay = 15000;
                                }
                                
                                setTimeout(function(){location.reload()},dalay);
                
            }
            else
            { 
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('form#popup_form_register .alerts-box').html(data.errors);
            }
        }).success(function(){$('form#popup_form_register .ajax-indicator').addClass('hidden');});
        return false;
    });

    function El(a){ return document.querySelector(a); }
    if(El('.switch_mobile_tabs')){
        $('.switch_mobile_tabs').click(function(){
            $('.terms_tabs_page').stop().slideToggle();
        });
        $('.terms_tabs_page li').click(function(){
            if(window.innerWidth < 768){
                    $('.switch_mobile_tabs').text($(this).find('a').text());
                    $('.terms_tabs_page').stop().slideUp();
            }
            
        });
    }
    
    
})

</script>

 

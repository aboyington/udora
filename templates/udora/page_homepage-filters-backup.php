<?php
$CI = &get_instance();
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
?>


<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
    <style>
    #codeigniter_profiler {
        display: none;
    }
</style>
</head>
<body class="no-padding">
<div class="page-popup-wrapper left-menu-wrapper page-login">
    <div class="left-menu">
        <div class="close-mobile-menu"><i class="ion-ios-close-outline"></i></div>
            <div class="col-xs-12 col-md-6 col-md-offset-3 border-login-account">
                <div class="login-form login-on-page" id="login-modal">
                    <div class="col-xs-12">
                    <h3><?php echo lang_check('Hello');?></h3>
                    <p class="sub-title text-left"><?php echo lang_check('Let\'s make today a great day!'); ?></p>
                    </div>                           
                    <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id'=>'popup_form_login')) ?>
                    <div class="login-inputs col-xs-12 col-lg-12 alerts-box">
                    </div>
                    <div class="login-inputs col-xs-12 col-lg-12">
                        <?php echo form_input('username', $this->input->get('username'), 'class="col-xs-12 col-lg-12" id="inputUsername" placeholder="' . lang('Username') . '"') ?>
                        <?php echo form_password('password', $this->input->get('password'), 'class="col-xs-12 col-lg-12" id="inputPassword" placeholder="' . lang('Password') . '"') ?>
                    </div>
                    <div class="clearfix">
                        <div class="checkbox remember-me col-xs-6">
                            <input name="remember" type="checkbox" value="true"  id="remember-me">
                            <label for="remember-me"> <?php echo lang('Remember me') ?></label>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <p class="business"> <a href="<?php echo site_url('admin/user/forgetpassword'); ?>"><?php echo lang_check('Forget password?') ?></a></p>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <button class="button-login col-xs-12 col-lg-12" type="submit"><?php echo lang_check('Login'); ?>
                            <div class="spinner hidden ajax-indicator">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                        </button>
                    </div>
                    <?php echo form_close() ?>
                    <div class="col-xs-12">
                        <p class="separate">
                            <span class="separate-content"><?php echo lang_check('Or login with email'); ?></span>
                        </p>
                    </div>
                    <div class="social-login col-xs-12">
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
                    <br style="clear: both;"/>
                    <div class="login-footer flex">
                        <div class="info"><?php echo lang_check('Don\'t have and account');?></div>
                        <div class="action">
                            <a href="<?php echo site_url('frontend/register');?>"  id="page-popup-open-register" class="btn button-login-inv"><?php echo lang_check('Sign up');?></a>
                        </div>
                    </div>
                </div> 
            </div>
    </div>
</div>
<div class="page-popup-wrapper left-menu-wrapper page-register">
    <div class="left-menu">
        <div class="close-mobile-menu"><i class="ion-ios-close-outline"></i></div>
            <div class="col-xs-12 col-md-6 col-md-offset-3 border-create-account">
                <div class="login-form create-account-form create-account-page">
                    <div class="col-xs-12">
                    <h3><?php echo lang_check('Create An Account');?></h3>
                    <p class="sub-title text-left"><?php echo lang_check('Please fill in the below form to create an account.'); ?></p>
                    </div>
                    <?php echo form_open(NULL, array('class' => 'form-horizontal form-additional widget-content clearfix', 'id'=>'popup_form_register')) ?>
                        <div class="login-inputs col-xs-12 col-lg-12 alerts-box">
                        </div>
                        <div class="login-inputs col-xs-12 col-lg-12 ">
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
                            <div class="clearfix text-left">
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
                            <button class="button-login col-xs-12" type="submit" ><?php echo lang_check('Sign up') ?>
                            <div class="spinner hidden ajax-indicator">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                    <p class="font_small col-lg-12 privacy"><?php echo lang_check('By creating an account'); ?></p>
                    <div class="col-xs-12">
                        <p class="separate">
                            <span class="separate-content"><?php echo lang_check('Or sign up with'); ?></span>
                        </p>
                    </div>
                    <div class="social-login col-xs-12">
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
                    <br style="clear: both;"/>
                    <div class="login-footer flex">
                        <div class="info"><?php echo lang_check('Already have a Udora acccount?');?></div>
                        <div class="action">
                            <a href="<?php echo site_url('frontend/login');?>" class="page-popup-open-login btn button-login-inv"><?php echo lang_check('Log in');?></a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
    
    
<div class="left-menu-wrapper wrapper-menu">
    <div class="left-menu">
        <div class="close-mobile-menu"><i class="ion-ios-close-outline"></i></div>
        <a href="index.html"><img src="assets/img/dark-logo.svg" alt="" class="logotype"></a>
        <?php
            if ( ! function_exists('get_menu_custom_mobile'))
            {
            //menu generate function
            function get_menu_custom_mobile ($array, $child = FALSE, $lang_code)
            {
                    $CI =& get_instance();
                    $str = '';

                $is_logged_user = ($CI->user_m->loggedin() == TRUE);

                    if (count($array)) {
                        $str .= $child == FALSE ? '<ul role="navigation">' . PHP_EOL : '<ul id="myDropdown" class="dropdown-content">' . PHP_EOL;
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

                                            $str .= $active ? '<li class="dropbtn active" data-pageid="'.$item['id'].'">' : '<li class="dropbtn" data-pageid="'.$item['id'].'">';
                                            $str .= '<a href="' . $href . '" data-toggle="dropdown" '.$target.'>' . $item['navigation_title'];
                                            $str .= '' . PHP_EOL;

                                            $str .= get_menu_custom_mobile($item['children'], TRUE, $lang_code);
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

                                            $str .= $active ? '<li class="dropbtn active"  data-pageid="'.$item['id'].'">' : '<li  data-pageid="'.$item['id'].'">';
                                            $str .= '<a href="' . $href . '" '.$target.'>' . $item['navigation_title'] . '</a>';

                                    }
                                    $str .= '</li>' . PHP_EOL;
                            }

                            $str .= '</ul>' . PHP_EOL;
                    }

                    return $str;
            }
            }
         ?>
        <?php
           $CI =& get_instance();
           echo get_menu_custom_mobile($CI->temp_data['menu'], FALSE, $lang_code);
       ?>
        <ul role="navigation">
            <li>
                <a href="<?php echo site_url($lang_code.'/142/blog_page');?>"><?php echo lang_check('Blog');?></a>
            </li>
            <li>
                <a href="<?php echo site_url($lang_code.'/180/udora_for_business');?>"><?php echo lang_check('Business');?></a>
            </li>
            <li>
                <a href="<?php echo site_url($lang_code.'/182/terms_of_service');?>"><?php echo lang_check('Terms & Privacy');?></a>
            </li>
            <li>
                <a href="https://udora.io/support/"><?php echo lang_check('Help');?></a>
            </li>
            <li>
                <a href="<?php echo site_url($lang_code.'/4/contact');?>"><?php echo lang_check('Contact');?></a>
            </li>
        </ul>
    </div>
</div>
<!-- Custom HTML -->
<!-- Main Container -->
<div class="sticky-navbar display-none"></div>
<div class="container-fluid home-wrapper">
  <!--  <div class="home-background-overlap"></div> -->
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container-fluid no-tablet-padding">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle gamburger-menu" data-toggle="collapse" id="left-menu-open">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{homepage_url_lang}"><img src="<?php echo $website_logo_url; ?>" alt="<?php echo $settings_websitetitle; ?>" class="logotype"></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
               <?php /*<li><a href="<?php echo site_url($lang_code.'/179/about');?>" class="white-colored">About</a></li>*/ ?>
                {not_logged}
                <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
<!--            <li><a href="{front_login_url}#content" id="page-popup-open-login" class="login-menu white-colored"><i class="fa fa-user-o" aria-hidden="true"></i> {lang_Login}</a></li> -->
                <li><a href="{front_login_url}#content" id="page-popup-open-login" class="login-menu white-colored"><i class="fa fa-user-o" aria-hidden="true"></i></a></li>
                <?php endif;?>
                {/not_logged}
                {is_logged_user}
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
                            <a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="standart-button">
                                <?php echo lang_check('Add Event');?>
                            </a>
                            <?php endif;?>
                            <a href="{logout_url}" class="standart-button">
                                {lang_Logout}
                            </a>
                        </div>
                    </div>
                </li>
                {/is_logged_user}
                {is_logged_other}
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
                            <a href="<?php echo site_url('admin/estate/edit');?>" class="standart-button">
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
    </nav>
    <div class="home__header__bg__wrap">
      <div class="home__header__bg" style="background-image: url('assets/img/home/exploreeveryday_opt45.jpg')"></div>
    </div>
    <!-- Search container -->
    <div class="main-home-container">
        <div class="home-container-content-wrapper">
           <?php /* <h4 class="container-header"><?php echo lang_check('Welcome to UDORA');?></h4> */?>
            <h2><?php echo lang_check('Find your next experience');?></h2>
            <?php _widget('custom_center_search');?>
            <div class="col-xs-12">
              <h5><?php echo lang_check('100M+ Events  |  30,000 Cities  |  4M Explorers');?></h5>
            </div>

        <?php /* <!--This php tag is only here to comment out the next 15 lines, remove it to reactivate the Popular places tree --> 
        <!-- Popular places-->
        <div class=" col-xs-12 popular-places-wrapper popular-places-wrapper-center col-lg-10 col-lg-offset-1">
           <p><?php echo lang_check('Popular places');?>: 
              <?php
                $CI = & get_instance();
                $treefield_id = 64;
                $CI->load->model('treefield_m');
                $treefields = array();
                $tree_listings = $CI->treefield_m->get_table_tree($lang_id, $treefield_id, NULL,true, '_lang.value', ', value_path');
                if (count($tree_listings)): foreach ($tree_listings as $listing_item): 
              ?>
              <?php 
                if(!empty($listing_item->body) || TRUE):
                    //$url = slug_url('treefield/'.$lang_code.'/'.$listing_item->id.'/'.url_title_cro($listing_item->value), 'treefield_m');
                    $url = site_url($lang_code.'/6/?search={"v_search_option_'.$treefield_id.'":"'.rawurlencode($listing_item->value_path.' - ').'"}');
               ?>
                <a href='<?php _che($url);?>'><?php echo $listing_item->value;?></a> <?php echo (next($tree_listings)) ? "|": "";?>
                <?php endif;endforeach;endif;?>
           </p>
        </div>
        */?>
        </div>
    </div>
    
     <a href="" class="scroll-button"><i class="material-icons">&#xE5CF;</i></a>
<!-- Footer -->
<?php _widget('custom_footer_menu');?>
</div>
<?php _widget('custom_javascript');?>
<?php _widget('tawk_javascript');?>

<script>

$('document').ready(function(){
    
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
                $('#popup_form_register .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                if(data.redirect) {
                    location.href = data.redirect;
                }
                location.reload();
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
    
    
    
})


</script>
</body>
</html>

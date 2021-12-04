<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <div class="container marg50">
        <div class="row">
            <div class="col-lg-9">
                <div class="title-page">
                    <h2>{page_title}</h2>
                    <span class="sub-title-page"><?php echo $agent_profile['type']; ?> | <?php echo $agent_profile['mail']; ?></span>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="listing_wrapper_agents">
                            <div class="agent_unit pr">
                                <div class="agent-unit-img-wrapper">
                                    <a href="{agent_image_url}">
                                        <div class="prop_new_details_back"></div>
                                        <div class="prop_new_details_back" style="background: url({agent_image_url});" class="img-responsive wp-post-image" ></div>
                                        <img src="{agent_image_url}" alt=""> 
                                    </a>
                                </div>
                                <div class="agent_unit_social agent_list">
                                    <div class="social-wrapper">
                                        <?php if (!empty($agent_profile['facebook_link'])): ?>
                                            <a href="<?php echo $agent_profile['facebook_link']; ?>"><i class="fa fa-facebook"></i></a>
                                        <?php endif; ?>
                                        <?php if (!empty($agent_profile['youtube_link'])): ?>
                                            <a href="<?php echo $agent_profile['youtube_link']; ?>"><i class="fa fa-youtube"></i></a>
                                        <?php endif; ?>
                                        <?php if (!empty($agent_profile['gplus_link'])): ?>
                                            <a href="<?php echo $agent_profile['gplus_link']; ?>"><i class="fa fa-google-plus"></i></a>
                                        <?php endif; ?>
                                        <?php if (!empty($agent_profile['twitter_link'])): ?>
                                            <a href="<?php echo $agent_profile['twitter_link']; ?>"><i class="fa fa-twitter"></i></a>
                                        <?php endif; ?>
                                        <?php if (!empty($agent_profile['linkedin_link'])): ?>
                                            <a href="<?php echo $agent_profile['linkedin_link']; ?>"><i class="fa fa-linkedin"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 agent_details">
                        <div class="mydetails">
                           <?php echo lang_check('My details');?>
                        </div>
                        <h3><a href="">{page_title}</a></h3>
                        <div class="agent_position">
                            <?php echo $agent_profile['type']; ?></div>
                        <div class="agent_detail agent_phone_class">
                            <i class="fa fa-mobile"></i><a href="tel:(305) 555-4555">{agent_phone}</a>
                        </div>
                        <div class="agent_detail agent_email_class"><i class="fa fa-envelope-o"></i>
                            <a href="mailto:<?php echo $agent_profile['mail']; ?>"><?php echo $agent_profile['mail']; ?></a>
                        </div>
                        <!--<div class="agent_detail agent_skype_class"><i class="fa fa-skype"></i>janet.wp</div>-->
                    </div>
                </div>
                <div class="marg20">
                    <h4 class=""><?php echo lang_check('About Me');?></h4>
                    <hr>
                    <p>
                        <?php
                        if(!empty($agent_profile['embed_video_code']))
                        {
                            echo $agent_profile['embed_video_code'];
                            echo '<br />';
                        }
                        ?>
                        <?php echo $agent_profile['description']; ?>
                     </p>

            </div>
            <div class="marg20 contact-section" id="form"> 
            <h4><?php echo lang_check('Contact me');?></h4>
            <hr>
                <form action="{page_current_url}#form" method="post">
                    <?php _che($validation_errors); ?>
                    <?php _che($form_sent_message); ?>
                    <!-- The form name must be set so the tags identify it -->
                    <input type="hidden" name="form" value="contact" />
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-lg-6">
                            <div class="form-group {form_error_firstname}">
                                <label for="name">{lang_FirstLast}</label>
                                <input id="firstname" class="form form-control" value="{form_value_firstname}" required="" name="firstname" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-lg-6">
                            <div class="form-group {form_error_email}">
                                <label for="email">{lang_Email}</label>
                                <input id="email" class="form form-control" value="{form_value_email}" name="email" required="" type="email">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-lg-12">
                            <div class="form-group {form_error_phone}">
                                <label for="phone">{lang_Phone}</label>
                                <input id="phone" class="form form-control" value="{form_value_phone}" name="phone" required="" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-lg-12">
                            <div class="form-group {form_error_message}">
                                <label for="msg">{lang_Message}</label>
                                <textarea name="message" rows="5" id="msg" class="form textarea form-control" placeholder="" required="">{form_value_message}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <?php if(config_item('captcha_disabled') === FALSE): ?>
                            <div class="control-group control-group-captcha">
                                <?php echo $captcha[ 'image']; ?>
                                <div class="captcha-input-box  form-group {form_error_captcha}">
                                    <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                    <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                            <div class="control-group form-group" >
                                <label class="control-label captcha"></label>
                                <div class="controls">
                                    <?php _recaptcha(true); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" id="valid-form" class="btn btn-default btn-udora-dark">{lang_Send}</button>
                </form>   
            </div>
            <div class="marg20" id="form"> 
                <h4><?php _l('More Events From This Organizer'); ?></h4>
                <hr>
                <div class="row properties-items" id="ajax_results">
                    <!-- PROPERTY LISTING -->
                    <?php foreach($agent_estates as $key=>$item): ?>
                    <?php
                        //if($key==0)echo '<div class="row">';
                    ?>
                        <?php _generate_results_item(array('key'=>$key, 'item'=>$item, 'custom_class'=>'col-sm-6 col-md-4 thumbnail-g')); ?>
                    <?php
                        if( ($key+1)%3==0 )
                        {
                            //echo '</div><div class="row">';
                        }
                        //if( ($key+1)==count($agent_estates) ) echo '</div>';
                        endforeach;
                    ?>
                    
                    <nav class="text-center">
                        <div class="pagination-ajax-results pagination  wp-block default product-list-filters light-gray pagination" rel="ajax_results">
                            <?php echo $pagination_links_agent; ?>
                        </div>
                    </nav>
                </div> <!-- /. recent properties -->
            </div>
            </div>
            <!-- Features Section Sidebar -->
            <div class="col-lg-3">
                <?php echo _widget('right_recentevents2');?>
                <?php echo _widget('right_ads');?>
            </div>
        </div>
        <?php echo _widget('bottom_imagegallery');?>
    </div>
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
    <?php _widget('custom_javascript');?>
</body>
</html>

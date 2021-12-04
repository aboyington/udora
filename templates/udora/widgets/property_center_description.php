<div class="row widget-property-description">
    <div class="cl-blog-text">
        <h3>{page_title}</h3>
        <?php 
        $end_date ='';
        $end_time ='';
        if(isset($estate_data_option_82) && !empty($estate_data_option_82)):
            $_strtotime = strtotime($estate_data_option_82);
            $end_time = date('g:i a', $_strtotime);
            $day = date('l',$_strtotime);
            $day = strtolower($day);
            $month = date('M',$_strtotime);
            $month = strtolower($month);
            $day_number = date('d',$_strtotime);
            $end_date = lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '.$day_number;
            ?>
        <?php endif;?>
        
        <?php if(isset($estate_data_option_81) && !empty($estate_data_option_81)):?>
            <div class="description__item top">
                <div class="description__item__icon">
                <i class="ion-android-time"></i>
                </div>
                <h5>
                <?php
                $_strtotime = strtotime($estate_data_option_81);
                $day = date('l',$_strtotime);
                $day = strtolower($day);
                $month = date('M',$_strtotime);
                $month = strtolower($month);
                $day_number = date('d',$_strtotime);
                $start_date = lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '.$day_number;
                ?>
                <?php echo $start_date;?> 
                    <?php if(!empty($end_date) && $end_date!=$start_date):?>
                        - <?php echo $end_date;?>
                    <?php endif;?>
                    
                    <?php if(!empty($end_time)):?>
                        <br> <?php echo date('g:i a', $_strtotime);?> - <?php echo $end_time;?>
                    <?php else:?>
                       <?php echo date('g:i a', $_strtotime);?>
                    <?php endif;?>
                </h5>
            </div>
        <?php endif;?>
        <div class="description__item">
            <div class="description__item__icon">
                <i class="ion-ios-location"></i>
            </div>
            <h5>{estate_data_address}</h5>
        </div>
        <div class="mobile__event__actions">
                        <?php if(file_exists(APPPATH.'controllers/admin/favorites.php') && FALSE):?>
            <?php
               $favorite_added = false;
               if(count($not_logged) == 0)
               {
                   $CI =& get_instance();
                   $CI->load->model('favorites_m');
                   $CI->load->library('session');
                   $favorite_added = $CI->favorites_m->check_if_exists($CI->session->userdata('id'), 
                                                                       $property_id);
                   if($favorite_added>0)$favorite_added = true;
               }
            ?>
                <div class="flex-1">
                    <a type="button"  class="btn btn-udora w-100 js-add-to-favorites" href="javascript:;" style="<?php echo ($favorite_added)?'display:none;':''; ?>">
                        <i class="fa fa-star favourite" aria-hidden="true"></i><?php echo lang_check(' Add to favorites'); ?> <i class="load-indicator"></i>
                    </a>
                    <a type="button" class="btn btn-udora w-100 js-remove-from-favorites" href="javascript:;" style="<?php echo (!$favorite_added)?'display:none;':''; ?>">
                        <?php echo lang_check(' Remove from favorites'); ?> <i class="fa fa-star favourite" aria-hidden="true"></i><i class="load-indicator"></i>
                    </a>
                </div>
            <?php endif;?>
                <?php if(config_item('report_property_enabled') == TRUE && isset($property_id) && isset($agent_id)): ?>

                <div class="mobile__event__actions__share">
                    <a class="btn btn-udora" href="javascript:;" id="js-open-share-dropdown">
                        <i class="ion-android-share-alt"></i>
                    </a>
                    <ul class="mobile__event__actions__share__dropdown" id="js-share-drodpown">
                        <li>
                            <a href="https://www.facebook.com/share.php?u={page_current_url}&title={page_title}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="btn btn-facebook">
                                <i class="ion-social-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://plus.google.com/share?url={page_current_url}" class="btn btn-google-plus" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                                <i class="ion-social-googleplus-outline"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?url={page_current_url}&via={settings_websitetitle}&related={page_title}" class="btn btn-twitter" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                                <i class="ion-social-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            
                    <?php if(!is_array($this->session->userdata('reported')) || !in_array($property_id, $this->session->userdata('reported'))): ?>
                            <div>
                            <a class="btn btn-udora popup-with-form-report" id="report_property" href="#popup_report_property" style=""><i class="icon-flag icon-white"></i> <i class="load-indicator"></i></a>
                        </div>
                    <?php else: ?>    
                    <?php endif; ?>  
            

                  <?php endif; ?>

            </div>
        <p><?php _che($estate_data_option_17, '<p class="alert alert-success">'.lang_check('Not available').'</p>'); ?></p>
    </div>
</div>


<script>
    $('document').ready(function(){

        $("#js-open-share-dropdown").on("click", function() {
            $("#js-share-drodpown").toggleClass("is-active");
        })

    });
</script>
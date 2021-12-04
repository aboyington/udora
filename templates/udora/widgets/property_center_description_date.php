<div class="row">
    <div class="cl-blog-text">
        <h3><?php echo html_entity_decode($page_title);?></h3>
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
            <h5>{estate_data_address}.</h5>
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
                <div class="flex-1 fav_box">
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
        <div class="descr_cont">
            <h4><?php echo lang_check('Description');?></h4>
            <div class="text_d">
            <?php _che(html_entity_decode(str_replace(array('&amp;','#39;','amp;','quot;'), '',$estate_data_option_17)), '<p class="alert alert-success">'.lang_check('Not available').'</p>'); ?>
            </div>
        </div>
    </div>
</div>

<?php if(config_item('report_property_enabled') == TRUE && isset($property_id) && isset($agent_id)): ?>
<form id="popup_report_property" class="form-horizontal mfp-hide white-popup-block">
    <div id="main">
        <div id="popup-form-validation-report">
        <p class="hidden alert alert-error"><?php echo lang_check('Submit failed, please populate all fields!'); ?></p>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputName"><?php echo lang_check('YourName'); ?></label>
            <div class="controls">
                <input type="text" name="name" class="form-control" id="inputName" value="<?php echo $this->session->userdata('name'); ?>" placeholder="<?php echo lang_check('YourName'); ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputPhone"><?php echo lang_check('Phone'); ?></label>
            <div class="controls">
                <input type="text" name="phone" class="form-control" id="inputPhone" value="<?php echo $this->session->userdata('phone'); ?>" placeholder="<?php echo lang_check('Phone'); ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputEmail"><?php echo lang_check('Email'); ?></label>
            <div class="controls">
                <input type="text" name="email" class="form-control" id="inputEmail" value="<?php echo $this->session->userdata('email'); ?>" placeholder="<?php echo lang_check('Email'); ?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="inputEmail"><?php echo lang_check('Message'); ?></label>
            <div class="controls">
                <textarea name="message" class="form-control" style='width: 220px;' id="message"><?php echo $this->session->userdata('message'); ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="checkbox">
                    <label>
                        <input name="allow_contact" class="" value="1" type="checkbox"> <?php echo lang_check('I allow agent and affilities to contact me'); ?>
                    </label>
                </div>
            </div>
        </div>
        
        <div class="control-group">
            <div class="controls">
                <button id="unhide-report-mask" type="button" class="btn"><?php echo lang_check('Submit'); ?></button>
                <img id="ajax-indicator-masking" src="assets/img/ajax-loader.gif" style="display: none;" />
            </div>
        </div>
    </div>
</form>


<script>
    // transfer to down page
    $('document').ready(function(){
      $('body').append($('#popup_report_property').detach());
    })
     
    $('document').ready(function(){

            $("#js-open-share-dropdown").on("click", function() {
                $("#js-share-drodpown").toggleClass("is-active");
            })

            // Popup form Start //
                $('#report_property.popup-with-form-report').magnificPopup({
                	type: 'inline',
                	preloader: false,
                	focus: '#name',
                                    
                	// When elemened is focused, some mobile browsers in some cases zoom in
                	// It looks not nice, so we disable it:
                	callbacks: {
                		beforeOpen: function() {
                			if($(window).width() < 700) {
                				this.st.focus = false;
                			} else {
                				this.st.focus = '#name';
                			}
                		}
                	}
                });
                
                
                $('#popup_report_property #unhide-report-mask').click(function(){
                    
                    var data = $('#popup_report_property').serializeArray();
                    data.push({name: 'property_id', value: "<?php echo $property_id; ?>"});
                    data.push({name: 'agent_id', value: "<?php echo $agent_id; ?>"});
                    
                    //console.log( data );
                    $('#popup_report_property #ajax-indicator-masking').css('display', 'inline');
                    
                    // send info to agent
                    $.post("<?php echo site_url('frontend/reportsubmit/'.$lang_code); ?>", data,
                    function(data){
                        if(data=='successfully')
                        {
                            // Display agent details
                            $('#report_property.popup-with-form-report').css('display', 'none');
                            // Close popup
                            $.magnificPopup.instance.close();
                            ShowStatus.show('<?php echo lang_check('Report send');?>')
                        }
                        else
                        {
                            $('.alert.hidden').css('display', 'block');
                            $('.alert.hidden').css('visibility', 'visible');
                            
                            $('#popup_report_property #popup-form-validation-report').html(data);
                            
                            //console.log("Data Loaded: " + data);
                        }
                        $('#popup_report_property #ajax-indicator-masking').css('display', 'none');
                    });

                    return false;
                });
                
            // Popup form End //     
    })
</script>

<?php endif; ?>
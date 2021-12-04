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
    
<body class="full-screen">
    <div class="fle">
        <?php _widget('header_menu');?>
        <?php _widget('custom_map_search_results');?>
    </div>
<!-- Footer -->
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
        <?php //_widget('custom_footer'); ?>
    </div>
<?php _widget('custom_javascript');?>

<!-- eventdetails (Dynamic Panel) -->
<div class="property_popup" style="display: none;">
    <div class="property_popup-content"style="position: relative; width: 100%; height: 100%;-webkit-overflow-scrolling:touch; overflow:auto;">
    </div>
    <div class="property_popup-close d-flex justify-content-between align-items-center" style="border-bottom:1px solid #bababa;">
        <div class="container">
        <div class="property_popup_c d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center more-event">
            <i class="material-icons close-icon">arrow_back</i>
        </div>
        
        <div class="col-sm-3 text-center">
            <span class="drop-share">
                <span class="item-parent"> <i class="material-icons ml-1 mr-1">share</i></span>
                <div class="drop-list">
                    <a href="#" class='facebook'><i class="fa fa-facebook"></i></a>
                    <a href="" class='twit-color'><i class="fa fa-twitter"></i></a>
                </div>
            </span>
            <span class="favorites-actions">
                <a href="#" data-id="2151" class="add-favorites-action" style="">
                    <i class="material-icons ml-1 mr-1">favorite_border</i>
                </a>
                <a href="#" data-id="2151" class="remove-favorites-action" style="display: none;">
                    <i class="material-icons ml-1 mr-1">favorite_border</i>
                </a>
            </span>
           
            <?php if(config_item('report_property_enabled') == TRUE): ?>
            <a id="report_property" href="#popup_report_property" class="popup-with-form-report"><i class="material-icons mr-1">outlined_flag</i></a>

            <!-- form itself -->
            <form id="popup_report_property" data-id="" class="form-horizontal mfp-hide white-popup-block">
                <div id="main">
                    <h2 class="title"><?php echo lang_check('Report Event');?></h2>
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
                            <textarea name="message" class="form-control" placeholder="<?php echo lang_check('Please add message'); ?>" id="message"><?php echo $this->session->userdata('message'); ?></textarea>
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
                                data.push({name: 'property_id', value: $('#popup_report_property').attr('data-id')});

                                //console.log( data );
                                $('#popup_report_property #ajax-indicator-masking').css('display', 'inline');

                                // send info to agent
                                $.post("<?php echo site_url('frontend/reportsubmit/'.$lang_code); ?>", data,
                                function(data){
                                    if(data=='successfully')
                                    {
                                        // Display agent details
                                        //$('#report_property.popup-with-form-report').css('display', 'none');
                                        // Close popup
                                        $.magnificPopup.instance.close();
                                        ShowStatus.show('<?php echo lang_check('Report send');?>')
                                        $('#popup_report_property').closest('form').find("input[type=text], textarea").val("");
                                    }
                                    else
                                    {
                                        $('.alert.hidden').css('display', 'block');
                                        $('.alert.hidden').css('visibility', 'visible');

                                        $('#popup_report_property #popup-form-validation-report').html(data);

                                    }
                                    $('#popup_report_property #ajax-indicator-masking').css('display', 'none');
                                });

                                return false;
                            });
                        // Popup form End //     
                })
            </script>
            <?php endif; ?>
        </div>
        </div>
        </div>
    </div>
</div>


<!-- eventdetails (Dynamic Panel) -->
<div class="popup_request_to_event hidden">
    <div class="popup_request_to_event-content login-form">
        <div class="popup_request_to_event-body">
            <h2 class="title"><?php echo lang_check('No events found');?></h2>
            <p><?php echo lang_check('If you would like to help us add events, please send us a message or click the +ADD EVENTS button.');?></p>
        </div>
        <div class="popup_request_to_event-footer">
            <a href="" class="btn btn-default popup_request_to_event-close"><?php echo lang_check('Close');?></a>
            <a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="btn btn-add">
                <i class="fa fa-plus"></i>
                <?php echo lang_check('Add Events');?>
            </a>
        </div>
    </div>
</div>


<script>

$(function(){
    $('.switch_res_map_btn_header').click(function(e){
        e.preventDefault();
        if($(this).hasClass('show_map')){
            $(this).removeClass('show_map');
             $('.results-wrapper').removeClass('mob-hidden')
            $('.map-wrapper').addClass('mob-hidden')
        } else {
             $(this).addClass('show_map');
             $('.results-wrapper').addClass('mob-hidden')
             $('.map-wrapper').removeClass('mob-hidden')
        }
    })
    
    $('.switch_res_list_btn_header').click(function(e){
        e.preventDefault();
        $('.switch_res_map_btn_header').removeClass('show_map');
        $('.results-wrapper').removeClass('mob-hidden')
        $('.map-wrapper').addClass('mob-hidden')
    })

    $('.property_popup .property_popup-close .more-event').click(function(){
        $('.property_popup').slideUp()
        $('body').removeClass('no-scroll')
        $('.property_popup .property_popup-content').html('')
    })
    
    $('.results-content .result-item .result-item-pop').click(function(e){
        e.preventDefault();
        var property_id = $(this).attr('data-property_id')
        reload_popup(property_id);
    })
    
    
    $('.popup_request_to_event .popup_request_to_event-close').click(function(e){
        e.preventDefault();
        $('.popup_request_to_event').addClass('hidden');
        $('.popup_request_to_event input').val('');
        $('.popup_request_to_event textarea').val('');
    })
    
    $('.popup_request_to_event form.popup_request_to_event-form').submit(function(e){
        e.preventDefault();
        var data = $('.popup_request_to_event form.popup_request_to_event-form').serializeArray();
        //console.log( data );
        $('.popup_request_to_event form.popup_request_to_event-form .ajax-indicator').removeClass('hidden');
        // send info to agent
        
        $.post("<?php echo site_url('api/popup_request_to_event/'.$lang_code); ?>", data,
        function(data){
            if(data.success)
            {
                // Display agent details
                $('.popup_request_to_event .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('.popup_request_to_event').addClass('hidden');
                $('.popup_request_to_event input').val('');
                $('.popup_request_to_event textarea').val('');
            }
            else
            { 
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('.popup_request_to_event .alerts-box').html(data.errors);
            }
        }).success(function(){
            $('.popup_request_to_event form.popup_request_to_event-form .ajax-indicator').addClass('hidden');});
        return false;
    });
    
})

function reload_popup(property_id) {
    
    $('.property_popup .property_popup-content').html('<iframe style="position: absolute; width: 100%; height: 100%" frameborder="0" src="<?php echo site_url('/property');?>/'+property_id+'/<?php echo $lang_code;?>?v=popup"></iframe>')
            
    $('.drop-share').find('.facebook').attr('href','https://www.facebook.com/share.php?u=<?php echo site_url('/property');?>/'+property_id+'/<?php echo $lang_code;?>');    
    $('.drop-share').find('.twit-color').attr('href','https://twitter.com/home?status=<?php echo site_url('/property');?>/'+property_id+'/<?php echo $lang_code;?>');    
            
    $('.favorites-actions').find('a').attr('data-id', property_id);
    $('#popup_report_property').attr('data-id', property_id);
    var data = { property_id: property_id };
    $.post("{api_private_url}/check_favorites/{lang_code}", data, 
    function(data){
        if(data.success)
        {
            $('.favorites-actions').find('a.add-favorites-action').css('display', 'inline-block')
            $('.favorites-actions').find('a.remove-favorites-action').css('display', 'none')
        } else {
            $('.favorites-actions').find('a.add-favorites-action').css('display', 'none')
            $('.favorites-actions').find('a.remove-favorites-action').css('display', 'inline-block')
        }
    });
    $('.modal-backdrop').hide();
    add_to_favorite();
    remove_from_favorites();
          
    $('.property_popup .property_popup-content iframe').ready(function(){
        $('body').addClass('no-scroll')
        $('.property_popup').slideDown();
    })
}

</script>
</body>
</html>
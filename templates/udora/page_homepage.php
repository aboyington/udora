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
        <?php// _widget('custom_footer_menu');?>
    </div>
    <div class="d-none d-md-block">
        <?php _widget('custom_footer'); ?>
    </div>
<?php _widget('custom_javascript');?>

<!-- eventdetails (Dynamic Panel) -->
<div class="property_popup" style="display: none;">
    <div class="property_popup-content"style="position: relative; width: 100%; height: 100%;-webkit-overflow-scrolling:touch; overflow:auto;">
    </div>
    <div class="property_popup-close d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center">
            <i class="material-icons close-icon">arrow_back</i>
            <p class="mb-0 ml-2">More Events</p>
        </div>
        
        <div>
            <i class="material-icons">share</i>
            <i class="material-icons">favorite_border</i>
            <i class="material-icons">more_vert</i>
        </div>
    </div>
</div>


<!-- eventdetails (Dynamic Panel) -->
<div class="popup_request_to_event hidden">
    <div class="popup_request_to_event-content login-form">
        <div class="popup_request_to_event-header">
            <?php echo lang_check('No events found');?>
            <div class="popup_request_to_event-close"><div class="close-icon black"></div></div>
       </div>
        <div class="popup_request_to_event-body">
            <p><?php echo lang_check('There were no events found that matched your search');?></p>
            <p><?php echo lang_check('If you would like to help add events, please send a message or click the Add Events button.');?></p>
            <p><?php echo lang_check('Thank you for your support');?></p>
        </div>
        <div class="popup_request_to_event-footer">
            <a href="<?php echo site_url('frontend/editproperty/'.$lang_code.'#content');?>" class="btn btn-add">
                <i class="fa fa-plus"></i>
                <?php echo lang_check('Add Events');?>
            </a>
            <a href="" class="btn btn-default popup_request_to_event-close"><?php echo lang_check('Close');?></a>
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

    $('.property_popup .property_popup-close').click(function(){
        $('.property_popup').slideUp()
				$('body').removeClass('no-scroll')
        $('.property_popup .property_popup-content').html('')
    })
    
    $('.results-content .result-item .result-item-pop').click(function(e){
        e.preventDefault();
        var property_id = $(this).attr('data-property_id')
        reload_popup(property_id)
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
    
    $('.property_popup .property_popup-content').html('<iframe style="position: absolute; width: 100%; height: 100%" frameborder="0" onload="var iOS=/iPad|iPhone|iPod/.test(navigator.userAgent)&&!window.MSStream; if(iOS) {this.parentNode.style.webkitOverflowScrolling = \'touch\'; this.parentNode.style.overflowY = \'scroll\';}"  src="<?php echo site_url('/property');?>/'+property_id+'/<?php echo $lang_code;?>?v=popup"></iframe>')
            
    $('.property_popup .property_popup-content iframe').ready(function(){
        $('body').addClass('no-scroll')
        $('.property_popup').slideDown();
    })
}



</script>
</body>
</html>
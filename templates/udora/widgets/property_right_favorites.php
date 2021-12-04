<?php if(file_exists(APPPATH.'controllers/admin/favorites.php')):?>
<?php
   $favorite_added = false;
   if(count($not_logged) == 0)
   {
       $CI =& get_instance();
       $CI->load->model('favorites_m');
       $favorite_added = $CI->favorites_m->check_if_exists($this->session->userdata('id'), 
                                                           $estate_data_id);
       if($favorite_added>0)$favorite_added = true;
   }
?>

<a type="button"  class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12 js-add-to-favorites" href="javascript:;" style="<?php echo ($favorite_added)?'display:none;':''; ?>">
   <i class="fa fa-star favourite" aria-hidden="true"></i><?php echo lang_check(' Add to favorites'); ?><i class="load-indicator"></i>
</a>

<a type="button" class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12 js-remove-from-favorites" href="javascript:;" style="<?php echo (!$favorite_added)?'display:none;':''; ?>">
    <i class="fa fa-star favourite" aria-hidden="true"></i><?php echo lang_check(' Remove from favorites'); ?><i class="load-indicator"></i>
</a>

<script type="text/javascript">
$(document).ready(function() {
    // [START] Add to favorites //  

    $(".js-add-to-favorites").click(function(e){
        e.preventDefault();
        var data = { property_id: {estate_data_id} };
        var load_indicator = $(this).find('.load-indicator');
        load_indicator.css('display', 'inline-block');
        $.post("{api_private_url}/add_to_favorites/{lang_code}", data, 
               function(data){

            ShowStatus.show(data.message);

            load_indicator.css('display', 'none');

            if(data.success)
            {
                $(".js-add-to-favorites").css('display', 'none');
                $(".js-remove-from-favorites").css('display', 'inline-block');
            }
        });

        return false;
    });

    $(".js-remove-from-favorites").click(function(e){
        e.preventDefault()
        var data = { property_id: {estate_data_id} };

        var load_indicator = $(this).find('.load-indicator');
        load_indicator.css('display', 'inline-block');
        $.post("{api_private_url}/remove_from_favorites/{lang_code}", data, 
               function(data){

            ShowStatus.show(data.message);

            load_indicator.css('display', 'none');

            if(data.success)
            {
                $(".js-remove-from-favorites").css('display', 'none');
                $(".js-add-to-favorites").css('display', 'inline-block');
            }
        });

        return false;
    });
    // [END] Add to favorites //  
});
</script>
<?php endif; ?>
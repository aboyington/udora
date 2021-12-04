<div class="footer style-1 d-md-none js-hide-when-login-open">
    <div class="footer-links">        
      
        <a href="<?php echo site_url('' . $lang_code . '#content'); ?>"
           class="footer-links__link js-footer-nav-discover">
            <i class="material-icons">search</i>
            <span class="footer-links__link__title">{lang_Explore}</span>
        </a>       
        <a href="<?php echo site_url('ffavorites/myfavorites/' . $lang_code . '#content'); ?>"
               class="footer-links__link">
               <i class="material-icons">favorite_border</i>
                <span class="footer-links__link__title">{lang_Saved}</span>
        </a>

        <div class="footer-links__link" id="checkin">
            <!-- <form action="#" class="footer-links__link-upload">
                <input type="file">
            </form> -->
            <svg xmlns="http://www.w3.org/2000/svg" width="25px" viewBox="0 0 29.07 28.54"><defs><style>.cls-1{fill:#f15a24;}</style></defs><g id="Layer_2" data-name="Layer 2" transform="matrix(1,0,0,1,0,2)"><g id="Foreground_Layer" data-name="Foreground Layer"><path class="cls-1" d="M7.37,22.54A7.34,7.34,0,0,1,0,15.18V0H2.6V15.18a4.77,4.77,0,0,0,9.54,0V4.27h2.6V15.18A7.34,7.34,0,0,1,7.37,22.54Z"/><path class="cls-1" d="M17.34,22.54V19.85c4.34,0,9-3.69,9-8.64s-4.2-8.64-9.23-8.64H4.34V0H17.12c6.53,0,12,4.83,12,11.27S23.41,22.54,17.34,22.54Z"/></g></g></svg>
            <i class="fa fa-search hidden"></i>
            <span class="footer-links__link__title">{lang_Check in}</span>
        </div>

        {is_logged_user}
        <a href="<?php echo site_url('frontend/editproperty/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/is_logged_user}
        {is_logged_other}
        <a href="<?php echo site_url('frontend/editproperty/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/is_logged_other}
        {not_logged}
        <a href="<?php echo site_url('frontend/login/' . $lang_code . '#content'); ?>" class="footer-links__link" >
            <i class="fa fa-plus"></i>
            <span class="footer-links__link__title">{lang_Add Event}</span>
        </a>
        {/not_logged}
        {is_logged_user}
        <a href="<?php echo site_url('frontend/myproperties/' . $lang_code . '#content'); ?>"
           class="footer-links__link footer_login_user-link">
            <i class="fa fa-user"></i>
            <span class="footer-links__link__title">{lang_Profile}</span>
        </a>
        {/is_logged_user}
        {is_logged_other}
        <a href="<?php echo site_url('frontend/myproperties/' . $lang_code . '#content'); ?>"
           class="footer-links__link">
            <i class="fa fa-user"></i>
            <span class="footer-links__link__title">{lang_Profile}</span>
        </a>
        {/is_logged_other}
        {not_logged}
        <a href="<?php echo site_url('frontend/myproperties/' . $lang_code . '#content'); ?>"
           class="footer-links__link js-toggle-login-popup js-close-mobile-navbar">
            <i class="fa fa-user"></i>
            <span class="footer-links__link__title">{lang_Login}</span>
        </a>
        {/not_logged}
    </div>
</div>


<script>
    $(function () {
        $('.home .js-footer-nav-discover').on('click', function (e) {
            e.preventDefault();
            $("#search_option_location_second").focus();
        })
    })
    
    $(function(){
        
        $('#checkin').on('click', function(){
            <?php
            $CI = &get_instance();
            // Check login and fetch user id
            $CI->load->library('session');
            $CI->load->model('user_m');
            if($this->user_m->loggedin() != TRUE)
            {
                
                echo 'ShowStatus.show("Please login for check in");';
                echo 'return false;';
            }
            ?>
                        
            var favorites_exists = false;;            
            
            $.ajax({
                url : '<?php echo site_url('privateapi/favorites_exists_check');?>',
                type : "post",
                async : false,
                success : function(data) {
                    if(data.success) {
                        favorites_exists = true;
                    } else {
                        ShowStatus.show("<?php echo lang_check('No events in favourites, please add');?>");
                    }
                }
            });
            
            if(!favorites_exists) {
                return false;
            }
            
            <?php
            $get_location_string ='';
            $get_location_city ='';
            $get_location_region ='';
            $get_location_country ='';

            // get user ip

            /* ip-api.com */

            $ip = $_SERVER['REMOTE_ADDR'];
            //$ip = "178.218.79.27";
            
            $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
            if($query && $query['status'] == 'success') :
                $get_location_string = $query ['city']. ", ".$query['country'];
            ?>
                        
            $.ajax({
                url : '<?php echo site_url('privateapi/attend_near_favorites');?>/<?php echo $lang_id;?>',
                type : "post",
                async : false,
                success : function(data) {
                    ShowStatus.show(data.message);
                    if(data.success) {
                    } else {
                    }
                }
            });      
                
            <?php else:?>
                $('#checkin_modal').modal('show');
            <?php endif;?>
        })
        
        if($('#checkin_modal').find('form').length) {
            var qr_form =  $('#checkin_modal').find('form');
            qr_form.submit(function(e){
                e.preventDefault();
                var data =  qr_form.serializeArray();
                // send info to agent
                
                
                var form = $(this);
                var formdata = false;
                if (window.FormData){
                    formdata = new FormData(form[0]);
                }

                var formAction = form.attr('action');
                $.ajax({
                    url         : "<?php echo site_url('privateapi/attend_by_ga_event_code/'.$lang_code); ?>",
                    data        : formdata ? formdata : form.serialize(),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(data, textStatus, jqXHR){
                        ShowStatus.show(data.message);
                        if(data.success)
                        {

                            qr_form.modal('hide');
                        }
                        else
                        {

                        }
                    }
                });
                
                /*
                $.post("<?php echo site_url('privateapi/attend_by_ga_event_code/'.$lang_code); ?>", data,
                function(data){
                    ShowStatus.show(data.message);
                    if(data.success)
                    {
                        
                        qr_form.modal('hide');
                    }
                    else
                    {
                        
                    }
                });*/

                return false;
            });
        }
    })
</script>
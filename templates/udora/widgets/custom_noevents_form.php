<!-- eventdetails (Dynamic Panel) -->
<div class="custom_noevents_form hidden">
    <div class="custom_noevents_form-content login-form">
        <div class="custom_noevents_form-header text-center">
<!--             <img style="width: 35px; margin-left: 15px;" src="assets/img/u211.png" alt=""> -->
          <i class="fa fa-frown-o fa-3x" aria-hidden="true" ></i>
            <br/>
            <br/>
            <?php echo lang_check('To help add events, please fill in this form.');?>
       </div>
        <form action="" class="popup_request_to_event-form clearfix" method="post">
            <div class="row login-inputs">
                <div class="login-inputs col-xs-12 col-lg-12 alerts-box">
                </div>
                
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    <div class="form-group">
                        <input id="firstname" placeholder="{lang_FirstLast}" required="" name="firstname" type="text">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-6">
                    <div class="form-group">
                        <input id="email" placeholder="{lang_Email}" name="email" required="" type="email">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="form-group">
                        <textarea name="message" style="width: 100%;" placeholder="{lang_Message}" rows="5" id="msg" required=""></textarea>
                    </div>
                </div>
            </div>
            <button class="button-login col-xs-12 col-lg-12 clearfix" type="submit"><?php echo lang_check('Send Message');?>
                <div class="spinner hidden ajax-indicator">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </button>
        </form>
    </div>
</div>




<script>

$(function(){
    
    $('.custom_noevents_form form.popup_request_to_event-form').submit(function(e){
        e.preventDefault();
        var data = $('.custom_noevents_form form.popup_request_to_event-form').serializeArray();
        //console.log( data );
        $('.custom_noevents_form form.popup_request_to_event-form .ajax-indicator').removeClass('hidden');
        // send info to agent
        
        $.post("<?php echo site_url('api/popup_request_to_event/'.$lang_code); ?>", data,
        function(data){
            if(data.success)
            {
                // Display agent details
                $('.custom_noevents_form .alerts-box').html('');
                if(data.message){
                    ShowStatus.show(data.message)
                }
                /*$('.custom_noevents_form').addClass('hidden');*/
                $('.custom_noevents_form input').val('');
                $('.custom_noevents_form textarea').val('');
            }
            else
            { 
                if(data.message){
                    ShowStatus.show(data.message)
                }
                $('.custom_noevents_form .alerts-box').html(data.errors);
            }
        }).success(function(){
            $('.custom_noevents_form form.popup_request_to_event-form .ajax-indicator').addClass('hidden');
        })
        return false;
    });
    
})


</script>

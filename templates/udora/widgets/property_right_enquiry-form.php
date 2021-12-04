<div class="promo-text-blog center-align col-xs-12" id="form">{lang_Enquireform}</div>
<!-- Contact form -->
<form id='ajax-contact-form' class="sidebar-form col-xs-12" action="{page_current_url}#form" name='contact-form' method='POST'>
    {validation_errors} {form_sent_message}
    <input type='hidden' name='form-name' value='contact-form' />
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="form-group {form_error_firstname}">
               <input type="text" id="firstname" name='firstname' class="form form-control" placeholder='{lang_FirstLast}' value="{form_value_firstname}">
                <label for="firstname">{lang_FirstLast}</label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="form-group {form_error_email}">
                <input type="text" name="email" id="email" placeholder="{lang_Email}" class="form form-control" value="{form_value_email}">
                <label for="email">{lang_Email}</label>
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="form-group {form_error_message}">
                <textarea id="message" name="message" class="form textarea form-control" rows="3" placeholder='{lang_Message}'></textarea>
                <label for="message">{lang_Message}</label>
            </div>
        </div>
        <?php if(config_item( 'captcha_disabled')===FALSE): ?>
            <div class="form-group {form_error_captcha}">
                <div class="row-fluid clearfix">
                    <div class="col-lg-6" style="padding-top:2px;">
                        <?php echo $captcha[ 'image']; ?>
                    </div>
                    <div class="col-lg-6">
                        <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                        <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                    </div>
                </div>
            </div>
        <?php endif; ?>   
        <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
        <div class="col-xs-12 col-sm-12 col-lg-12" >
            <label class="control-label captcha"></label>
            <div class="controls">
                <?php _recaptcha(true); ?>
            </div>
        </div>
        <?php endif; ?>    
    </div>
    <button type="submit" id="valid-form" class="btn sidebar-button accent-button">{lang_Send}</button>
</form>
<?php
/*
Widget-title: Contact form
Widget-preview-image: /assets/img/widgets_preview/center_contactform.jpg
*/
?>


<h4 id="form-contact"><?php echo lang_check('Contactus');?></h4>
<hr>
<form action="{page_current_url}#form-contact" method="post">
    <?php _che($validation_errors); ?>
    <?php _che($form_sent_message); ?>
    <input type='hidden' name='form-name' value='contact-form' />
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
                <div class="controls">
                    <?php _recaptcha(false); ?>
                </div>
							  <label class="control-label captcha"></label>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" id="valid-form" class="btn btn-default btn-udora-dark">{lang_Send}</button>
</form>
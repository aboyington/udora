<?php
/* Popup form 
 * lib 
 *  css: assets/libraries/magnific-popup/magnific-popup.css
 *  js: assets/libraries/magnific-popup/jquery.magnific-popup.js
 *  link: https://plugins.jquery.com/magnific-popup/ ???
 * 
 */

?>

<?php if(config_item('report_property_enabled') == TRUE && isset($property_id) && isset($agent_id)): ?>
<div class="hidden-xs">
<?php if(!is_array($this->session->userdata('reported')) || !in_array($property_id, $this->session->userdata('reported'))): ?>
<a class="btn button-standart add-event-btn col-xs-12 col-sm-6 col-lg-12 popup-with-form-report" style="margin-top:30px;" id="report_property" href="#popup_report_property" style=""><i class="fa fa-flag" aria-hidden="true"></i><?php echo lang_check(' Report property'); ?><i class="load-indicator"></i></a>
<?php endif; ?>    
</div>
<!-- form itself -->
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


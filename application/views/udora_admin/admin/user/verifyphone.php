<div>
   <a class="hiddenanchor" id="signup"></a>
   <a class="hiddenanchor" id="signin"></a>

   <div class="login_wrapper">
     <div class="animate form login_form">
       <section class="login_content">
            <?php echo form_open(NULL, array('class' => 'form-horizontal'))?>
           <h1> <?php echo lang_check('Verify  phone')?>  </h1>
           <div>
            <div class="padd-alert">
                <?php echo validation_errors() ?>
                <?php if ($this->session->flashdata('message')): ?>
                    <?php echo $this->session->flashdata('message') ?>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                <?php endif; ?>     
                <?php if($is_logged && $this->session->flashdata('message')!=lang_check('Thank you, phone number verified!')): ?> <?php endif;?>
            </div>
             <?php echo form_input('phone', set_value('phone', $this->data['user']->phone), 'class="form-control" id="inputPassword" placeholder="'.lang_check('Your phone number').'" autocomplete="off"')?>
           </div>
           <div>
             <?php echo form_input('code', set_value('code', ''), 'class="form-control" id="inputPassword" placeholder="'.lang_check('Your verification code').'" autocomplete="off"')?>
           </div>
           <div>
               <button type="submit" class="btn btn-primary-blue"><?php echo lang_check('Send new verification message')?></button>
                <div style="clear: both; padding-top: 3px;"> </div>
                <button type="submit" class="btn btn-info"><?php echo lang_check('Confirm your verification code')?></button>
                <br style="clear: both;" />
           </div>
           <div class="clearfix"></div>

           <div class="separator">
             <p class="change_link">New to site?
               <a href="<?php echo site_url('frontend/register')?>" class="to_register"> <?php echo lang_check('Create Account');?> </a>
             </p>

             <div class="clearfix"></div>
             <br />

              <div>
             <img src="<?php echo base_url('adminudora-assets/images/udora_logo_icon.svg') ?>" alt="Udora logo" style="height:40px; margin-bottom: 2em">
               <p>© Udora Technologies | Trademarks and brands are the property of their respective owners.</p>
             </div>
           </div>
            <?php echo form_close()?>
       </section>
     </div>
   </div>
 </div>
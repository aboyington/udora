<div>
   <a class="hiddenanchor" id="signup"></a>
   <a class="hiddenanchor" id="signin"></a>

   <div class="login_wrapper">
     <div class="animate form login_form">
       <section class="login_content">
           <?php echo form_open(NULL, array('class' => 'form-horizontal'))?>
           <h1><?php echo lang_check('Verify your email')?> </h1>
           <div>
            <div class="padd-alert">
                <?php if(isset($message)):?>
                <?php echo $message; ?>
                <?php endif;?>
                <?php if($activated):?>
                <p class="activated_text">
                    Your account was activated successfully! you can now <a href="<?php echo site_url('/frontend/login/')?>" class="link">log in</a> with the username and password you provided when you signed up.
                </p> 
                <?php endif;?>
            </div>
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

<style>
    
    .label.label-info {
        background: #e2f9f5!important;
        color: #3a776b;
        border: 1px solid #56a797;
        border-radius: 0;
        padding: 15px 10px !important;
    }
    
    .activated_text {
        font-size: 14px;
        padding-top: 15px;
        padding-bottom: 5px;
    }
    
    .activated_text .link {
        font-size: 14px;
        margin: 0;
        color: #00cb9a;
    }
    
    .login_content form div a.udora-btn {
        padding: 10px;
        width: 100%;
        color: #fff;
        border: none;
        outline: 0;
        font-size: 14px;
        font-weight: 400;
        border-radius: 3px;
        display: inline-block;
        background: #F15927;
        margin: 10px 0;
        text-decoration: none;
        
    }
    
    .login_content form div a.udora-btn:hover {
        background: #d74e21;
        color: #fff;
        text-decoration: none;
    }
    
</style>
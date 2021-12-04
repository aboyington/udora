<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
      <div id="register" class="animate form registration_form show">
        <section class="login_content">
           <?php echo form_open(NULL, array('class' => 'form-horizontal'))?>
            <h1><?php echo lang_check('Create Account');?></h1>
            <div class="padd-alert">
                <?php echo validation_errors() ?>
                <?php if ($this->session->flashdata('message')): ?>
                    <?php echo $this->session->flashdata('message') ?>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                <?php endif; ?>     
                <hr />
            </div>
            <div>
               <?php echo form_input('name_surname', set_value('name_surname', $user->name_surname), 'class="form-control" id="inputNameSurname" placeholder="'.lang('Name and surname').'"')?>
            </div>
            <div>
              <?php echo form_input('username', set_value('username', $user->username), 'class="form-control" id="inputUsername" placeholder="'.lang('Username').'"')?>
            </div>
            <div>
              <?php echo form_password('password', set_value('password', ''), 'class="form-control" id="inputPassword" placeholder="'.lang('Password').'" autocomplete="off"')?>
            </div>
            <div>
              <?php echo form_password('password_confirm', set_value('password_confirm', ''), 'class="form-control" id="inputPasswordConfirm" placeholder="'.lang('PasswordConfirm').'" autocomplete="off"')?>
            </div>
            <div>
               <?php echo form_textarea('address', set_value('address', $user->address), 'placeholder="'.lang('Address').'" rows="3" class="form-control"')?>
            </div>
            <div>
              <?php echo form_input('phone', set_value('phone', $user->phone), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
            </div>
            <div>
              <?php echo form_input('mail', set_value('mail', $user->mail), 'class="form-control" id="inputMail" placeholder="'.lang('Mail').'"')?>
            </div>
            <div>
               <?php echo form_dropdown('language', $this->language_m->backend_languages, set_value('language', 'english'), 'class="form-control"');?>
            </div>
            <div>
            <button type="submit" class="btn btn-primary submit"><?php echo lang('Register')?></button>
            <button type="reset" class="btn btn-default submit"><?php echo lang('Reset')?></button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link"><?php echo lang_check('Already a member ?');?>
                <a href="<?php echo site_url('admin/user/login')?>" class="to_register"> <?php echo lang_check('Log in');?></a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <img src="<?php echo base_url('adminudora-assets/images/udora_logo_icon.svg') ?>" alt="Udora logo" style="height:40px; margin-bottom: 2em">
                <p>© 2017 Udora Technologies | Trademarks and brands are the property of their respective owners.</p>
              </div>
            </div>
          <?php echo form_close()?>
        </section>
      </div>
    </div>
  </div>
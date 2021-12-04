<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Ga Event')?></h3>
    </div>

    <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <?php echo form_open('admin/dashboard/search');?>
            <div class="input-group">
              	<input type="text" class="form-control col-md-7 col-xs-12" name="search" placeholder="<?php echo lang_check('Search')?>" />
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Go!</button>
                </span>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo empty($ga_event->id) ? lang_check('Add a new ga event') : lang_check('Edit ga event').' "' . $ga_event->title.'"'?></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br/>
                <?php echo validation_errors()?>
                <?php if($this->session->flashdata('message')):?>
                <?php echo $this->session->flashdata('message')?>
                <?php endif;?>
                <?php if($this->session->flashdata('error')):?>
                <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                <?php endif;?>
                <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Estate')?></label>
                      <div class="col-lg-10">
                          
                        <?php 
                          if(!set_value('listing_id', $ga_event->listing_id) && isset($_GET['lisitng_id'])) {
                              $ga_event->listing_id = $_GET['lisitng_id'];
                          }
                        ?>
                          
                        <?php echo form_dropdown('listing_id', $all_estates, set_value('listing_id', $ga_event->listing_id), 'class="form-control"');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php _l('Title')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('title', set_value('title', $ga_event->title), 'class="form-control" id="inputTitle" placeholder="'.lang_check('Title').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Description')?></label>
                      <div class="col-lg-10">
                        <?php echo form_textarea('description', set_value('description', $ga_event->description), 'class="form-control" id="inputdescription" placeholder="'.lang_check('Description').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Event key')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('event_key', set_value('event_key', $ga_event->event_key), 'class="form-control" id="inputevent_key" placeholder="'.lang_check('Event_key').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Qr code')?></label>
                      <div class="col-lg-10">
                          <img id="qr_code_event" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo site_url('event_confirm/confirmation/'.$ga_event->event_key);?>&choe=UTF-8" alt="">
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang_check('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/estate/ga_events')?>" class="btn btn-danger" type="button"><?php echo lang_check('Cancel')?></a>
                        <?php if(isset($ga_event->email)):?>
                        <a href="mailto:<?php echo $ga_event->email?>?subject=<?php echo lang_check('Reply on ga_event for real estate')?>: <?php echo $all_estates[$ga_event->listing_id]?>&amp;body=<?php echo $ga_event->message?>" class="btn btn-success" target="_blank"><?php echo lang_check('Reply to email')?></a>
                        <?php endif;?>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


<script>
$(function(){
    $('#inputevent_key').change(function(){
        var v = $(this).val();
        if(v.length && v.length==4)
            $('#qr_code_event').attr('src','https://chart.googleapis.com/chart?chs=300x300&cht=qr&choe=UTF-8&chl=<?php echo site_url('event_confirm/confirmation/');?>/'+v)
    })
    
})
</script>
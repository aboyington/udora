<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Q&A')?></h3>
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
                <h2><?php echo empty($expert->id) ? lang_check('Add question') : lang_check('Edit question').' "' . $expert->id.'"'?></h2>
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
                <div class="padd-alert">
                    <?php echo validation_errors() ?>
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php echo $this->session->flashdata('message') ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                    <?php endif; ?>     
                </div>
                <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Category')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('parent_id', $experts_no_parents, $this->input->post('parent_id') ? $this->input->post('parent_id') : $expert->parent_id, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Expert')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('answer_user_id', $experts_user, $this->input->post('answer_user_id') ? $this->input->post('answer_user_id') : $expert->answer_user_id, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Date publish')?></label>
                      <div class="col-lg-5">
                      <div class="input-group date myDatepicker_full" id="datetimepicker1">
                        <?php echo form_input('date_publish', $this->input->post('date_publish') ? $this->input->post('date_publish') : $expert->date_publish, 'class="form-control" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                         <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                         </span>
                      </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Readed')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('is_readed', '1', set_value('is_readed', $expert->is_readed), 'id="inputReaded"')?>
                      </div>
                    </div>

                    <hr />
                    <h5><?php echo lang('Translation data')?></h5>
                   <div style="margin-bottom: 0px;" class="tabbable">
                      <ul class="nav nav-tabs">
                        <?php $i=0;foreach($this->qa_m->languages as $key_lang=>$val_lang):$i++;?>
                        <li class="<?php echo $i==1?'active':''?>"><a data-toggle="tab" href="#<?php echo $key_lang?>"><?php echo $val_lang?></a></li>
                        <?php endforeach;?>
                      </ul>
                      <div style="padding-top: 25px;" class="tab-content">
                        <?php $i=0;foreach($this->qa_m->languages as $key_lang=>$val_lang):$i++;?>
                        <div id="<?php echo $key_lang?>" class="tab-pane <?php echo $i==1?'active':''?>">
                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang_check('Question')?></label>
                              <div class="col-lg-10">
                                <?php echo form_textarea('question_'.$key_lang, set_value('question_'.$key_lang, $expert->{'question_'.$key_lang}), 'placeholder="'.lang('Question').'" rows=4" class="form-control"')?>
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang_check('Answer')?></label>
                              <div class="col-lg-10">
                                <?php echo form_textarea('answer_'.$key_lang, set_value('answer_'.$key_lang, $expert->{'answer_'.$key_lang}), 'placeholder="'.lang('Answer').'" rows=4" class="form-control"')?>
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="col-lg-2 control-label"><?php echo lang('Keywords')?></label>
                              <div class="col-lg-10">
                                <?php echo form_input('keywords_'.$key_lang, set_value('keywords_'.$key_lang, $expert->{'keywords_'.$key_lang}), 'class="form-control" id="inputKeywords'.$key_lang.'" placeholder="'.lang('Keywords').'"')?>
                              </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/expert')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>


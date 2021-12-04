<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang('Page')?></h3>
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
                <h2><?php echo lang('Page data')?></h2>
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
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Parent')?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_dropdown('parent_id', $pages_no_parents, $this->input->post('parent_id') ? $this->input->post('parent_id') : $page->parent_id, 'class="form-control col-md-7 col-xs-12"')?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Template')?></label>
                      <div class="col-lg-4">
                        <?php echo form_dropdown('template', $templates_page, $this->input->post('template') ? $this->input->post('template') : $page->template, 'class="form-control select_template"'); ?>
                      </div>
                      <div class="col-lg-6">
                        <a href="#" rel="<?php echo site_url('admin/templates/edit/'); ?>" target="_blank" class="hide edit_template btn btn-primary-blue"><?php _l('Edit template'); ?></a>
                      </div>
                        <script type="text/javascript">
                        $(function() {
                        $('select.select_template').on('change', function() {
                        if(this.value.substr(0, 7) == 'custom_')
                        {
                        $('a.edit_template').removeClass('hide');
                        $('a.edit_template').attr('href', $('a.edit_template').attr('rel')+'/'+this.value.substr(7));
                        }
                        else
                        {
                        $('a.edit_template').addClass('hide');
                        }
                        });
                        console.log($('select.select_template').val());
                        if($('select.select_template').val().substr(0, 7) == 'custom_')
                        {
                        $('a.edit_template').removeClass('hide');
                        $('a.edit_template').attr('href', $('a.edit_template').attr('rel')+'/'+$('select.select_template').val().substr(7));
                        }
                        });
                        </script>
                    </div>
                    <?php if(count($templates_headers) > 0): ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php _l('Template headers')?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_dropdown('template_header', $templates_headers, $this->input->post('template_header') ? $this->input->post('template_header') : $page->template_header, 'class="form-control col-md-7 col-xs-12"'); ?>
                      </div>
                    </div>
                    <?php endif; ?>

                    <?php if(count($templates_footers) > 0): ?>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php _l('Template footers')?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_dropdown('template_footer', $templates_footers, $this->input->post('template_footer') ? $this->input->post('template_footer') : $page->template_footer, 'class="form-control col-md-7 col-xs-12"'); ?>
                      </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Show as')?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_dropdown('type', array('PAGE'=>lang_check('Page'), 'ARTICLE'=>lang_check('Article')), $this->input->post('type') ? $this->input->post('type') : $page->type, 'class="form-control col-md-7 col-xs-12"'); ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Visible in menu')?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_checkbox('is_visible', '1', set_value('is_visible', $page->is_visible), 'id="inputVisible"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('Visible for logged users')?></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php echo form_checkbox('is_private', '1', set_value('is_private', $page->is_private), 'id="inputPrivate"')?>
                      </div>
                    </div>

                    <hr />
                    <h5><?php echo lang('Translation data')?></h5>
                   <div style="margin-bottom: 0px;" class="tabbable">
                      <ul class="nav nav-tabs">
                        <?php $i=0;foreach($this->page_m->languages as $key_lang=>$val_lang):$i++;?>
                        <li class="<?php echo $i==1?'active':''?> lang"><a data-toggle="tab" href="#<?php echo $key_lang?>"><?php echo $val_lang?></a></li>
                        <?php endforeach;?>

                        <?php if(count($this->page_m->languages) > 1): ?>
                        <li class="pull-right"><a href="#" id="copy-lang" class="btn btn-default" type="button"><?php echo lang_check('Copy to other languages')?></a></li>
                        <li class="pull-right"><a href="#" id="translate-lang" rel="<?php echo site_url('api/translate/');  ?>" class="btn btn-default" type="button"><?php echo lang_check('Translate to other languages')?></a></li>
                        <?php endif; ?>

                      </ul>
                      <div style="padding-top: 25px;" class="tab-content">
                        <?php $i=0;foreach($this->page_m->languages as $key_lang=>$val_lang):$i++;?>
                        <div id="<?php echo $key_lang?>" class="tab-pane <?php echo $i==1?'active':''?>">
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Title')?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php echo form_input('title_'.$key_lang, set_value('title_'.$key_lang, $page->{'title_'.$key_lang}), 'class="form-control copy_to_next" id="inputOption_'.$key_lang.'_1" placeholder="'.lang('Title').'"')?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Navigation title')?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php echo form_input('navigation_title_'.$key_lang, set_value('navigation_title_'.$key_lang, $page->{'navigation_title_'.$key_lang}), 'class="form-control col-md-7 col-xs-12" id="inputOption_'.$key_lang.'_2" placeholder="'.lang('Navigation title').'"')?>
                              </div>
                            </div>
                            <?php if(config_db_item('slug_enabled') === TRUE): ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang_check('URI slug')?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php echo form_input('slug_'.$key_lang, set_value('slug_'.$key_lang, $page->{'slug_'.$key_lang}), 'class="form-control col-md-7 col-xs-12" id="inputOption_'.$key_lang.'_slug" placeholder="'.lang_check('URI slug').'"')?>
                              </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Keywords')?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php echo form_input('keywords_'.$key_lang, set_value('keywords_'.$key_lang, $page->{'keywords_'.$key_lang}), 'class="form-control col-md-7 col-xs-12" id="inputOption_'.$key_lang.'_3" placeholder="'.lang('Keywords').'"')?>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Description')?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php echo form_textarea('description_'.$key_lang, set_value('description_'.$key_lang, $page->{'description_'.$key_lang}), 'placeholder="'.lang('Description').'" rows=4" class="form-control col-md-7 col-xs-12" id="inputOption_'.$key_lang.'_4"')?>
                              </div>
                            </div>  

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo lang('Body')?></label>
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <?php echo form_textarea('body_'.$key_lang, set_value('body_'.$key_lang, $page->{'body_'.$key_lang}), 'placeholder="'.lang('Body').'" rows="10" class="ckeditor form-control" id="inputOption_'.$key_lang.'_5"')?>
                              </div>
                            </div>  
                        </div>
                        <?php endforeach;?>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?php echo form_submit('submit', lang('Submit'), 'class="btn btn-primary-blue"')?>
                        <button class="btn btn-danger" type="reset"><?php echo lang_check('Reset');?></button>
                        <a href="<?php echo site_url('admin/page')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                      </div>
                    </div>
                <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>



<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Files')?></h2>
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
            <?php if(!isset($page->id)):?>
            <span class="label label-danger"><?php echo lang('After saving, you can add files and images');?></span>
            <?php else:?>
            <p>By order, first image will be used as profile and second as agency logo.</p>
            <div class="page-files-box" id="page-files-<?php echo $page->id?>" rel="page_m">
                <!-- The file upload form used as target for the file upload widget -->
                <form class="fileupload" action="<?php echo site_url('files/upload/'.$page->id);?>" method="POST" enctype="multipart/form-data">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value="<?php echo site_url('admin/page/edit/'.$page->id);?>"></noscript>
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="fileupload-buttonbar row">
                        <div class="col-md-7">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-primary-blue fileinput-button">
                                <i class="fa fa-plus m-right-xs"></i>
                                <span><?php echo lang('add_files...')?></span>
                                <input type="file" name="files[]" multiple>
                            </span>
                            <button type="reset" class="btn btn-danger cancel">
                                <i class="fa fa-minus m-right-xs"></i>
                                <span><?php echo lang('cancel_upload')?></span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="fa fa-trash m-right-xs"></i>
                                <span><?php echo lang('delete_selected')?></span>
                            </button>
                            <input type="checkbox" class="toggle" />
                        </div>
                        <!-- The global progress information -->
                        <div class="col-md-5 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="bar" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress information -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The loading indicator is shown during file processing -->
                    <div class="fileupload-loading"></div>
                    <br />
                    <!-- The table listing the files available for upload/download -->
                    <!--<table role="presentation" class="table table-striped">
                    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">-->

                      <div role="presentation" class="fieldset-content">
                        <div class="row files files-list"  data-toggle="modal-gallery" data-target="#modal-gallery">
                        <?php if(isset($files[$page->repository_id]))foreach($files[$page->repository_id] as $file ):?>
                        <div class="col-md-55 img-rounded template-download fade in">
                            <div class="thumbnail">
                                <div class="image view view-first">
                                    <div class="preview">
                                        <img style="width: 100%; display: block;" data-src="<?php echo $file->thumbnail_url?>" src="<?php echo $file->thumbnail_url?>" alt="<?php echo $file->filename?>" />
                                    </div>
                                    <div class="mask">
                                        <p><?php echo character_hard_limiter($file->filename, 20)?></p>
                                        <div class="tools tools-bottom options-container">
                                            <?php if($file->zoom_enabled):?>
                                            <a class="zoom-button" rel="<?php echo $file->filename?>" href="<?php echo $file->download_url?>"><i class="fa icon-zoom-in"></i></a>
                                            <a class="iedit visible-inline-lg" rel="<?php echo $file->filename?>" href="#<?php echo $file->filename?>"><i class="fa fa-pencil"></i></a>
                                            <a data-gallery="gallery" href="<?php echo $file->download_url?>" title="<?php echo $file->filename?>" download="<?php echo $file->filename?>"><i class="fa fa-link"></i></a>                  
                                            <?php else:?>
                                            <a target="_blank" href="<?php echo $file->download_url?>" title="<?php echo $file->filename?>" download="<?php echo $file->filename?>"><i class="fa fa-link"></i></a>
                                            <?php endif;?>
                                            <div class="delete">
                                                <button class="" data-type="POST" data-url="<?php echo $file->delete_url?>"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <p><?php echo lang_check('Remove');?>
                                    <input type="checkbox" value="1" name="delete">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        </div>
                        <br style="clear:both;"/>
                      </div>
                </form>

            </div>

            <?php endif;?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url('adminudora-assets/js/zebra/css/flat/zebra_dialog.css')?>">
<script src="<?php echo base_url('adminudora-assets/js/zebra/javascript/zebra_dialog.src.js')?>"></script>
<script>

/* CL Editor */
$(document).ready(function(){    
    $('.files a.iedit').click(function (event) {
        new $.Zebra_Dialog('', {
            source: {'iframe': {
                'src':  '<?php echo site_url('admin/imageeditor/edit'); ?>/'+$(this).attr('rel'),
                'height': 700
            }},
            width: 950,
            title:  '<?php _l('Edit image'); ?>',
            type: false,
            buttons: false
        });
        return false;
    });
});

</script>

<div class="page-title">
    <div class="title_left">
        <h3><?php echo empty($ad->id) ? lang_check('Add a new ad') : lang_check('Edit ad').' "' . $ad->id.'"'?></h3>
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
                <h2><?php echo lang('Ad data')?></h2>
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
                      <label class="col-lg-2 control-label"><?php echo lang('Type')?></label>
                      <div class="col-lg-10">
                        <?php echo form_dropdown('type', $this->ads_m->ads_types, set_value('type', $ad->type), 'class="form-control"');?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Title')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('title', set_value('title', $ad->title), 'class="form-control" id="inputTitle" placeholder="'.lang_check('Title').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('Link')?></label>
                      <div class="col-lg-10">
                        <?php echo form_input('link', set_value('link', $ad->link), 'class="form-control" id="inputLink" placeholder="'.lang_check('Link').'"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Description')?></label>
                      <div class="col-lg-10">
                        <?php echo form_textarea('description', set_value('description', $ad->description), 'placeholder="'.lang('Description').'" rows="3" class="form-control"')?>
                      </div>
                    </div>      

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Activated')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('is_activated', '1', set_value('is_activated', $ad->is_activated), 'id="inputActivated"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang('Random')?></label>
                      <div class="col-lg-10">
                        <?php echo form_checkbox('is_random', '1', set_value('is_random', $ad->is_random), 'id="inputRandom"')?>
                      </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/ads')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
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
                <h2><?php echo lang('Images')?></h2>
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
            <?php if(!isset($ad->id)):?>
            <span class="label label-danger"><?php echo lang('After saving, you can add files and images');?></span>
            <?php else:?>
            <div class="page-files-box" id="page-files-<?php echo $ad->id?>" rel="ads_m">
                <!-- The file upload form used as target for the file upload widget -->
                <form class="fileupload" action="<?php echo site_url('files/upload_ads/'.$ad->id);?>" method="POST" enctype="multipart/form-data">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value="<?php echo site_url('admin/page/edit/'.$ad->id);?>"></noscript>
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
                        <?php if(isset($files[$ad->repository_id]))foreach($files[$ad->repository_id] as $file ):?>
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

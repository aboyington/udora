<div class="page-title">
    <div class="title_left">
        <h3><?php echo empty($option->id) ? lang('Add a option') : lang('Edit option').' #' . $option->id.''?></h3>
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
                <h2><?php echo lang('Option data')?></h2>
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
                      <label class="col-lg-3 control-label"><?php echo lang('Type')?></label>
                      <div class="col-lg-9">
                        <?php echo form_dropdown('type', $this->option_m->option_types, $this->input->post('type') ? $this->input->post('type') : $option->type, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Parent')?></label>
                      <div class="col-lg-9">
                        <?php echo form_dropdown('parent_id', $options_no_parents, $this->input->post('parent_id') ? $this->input->post('parent_id') : $option->parent_id, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Visible in table')?></label>
                      <div class="col-lg-9">
                        <?php echo form_checkbox('visible', '1', $this->input->post('visible') ? $this->input->post('visible') : $option->visible)?>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Locked')?></label>
                      <div class="col-lg-9">
                        <?php echo form_checkbox('is_locked', '1', $this->input->post('is_locked') ? $this->input->post('is_locked') : $option->is_locked)?>
                        <span class="label label-warning"><?php echo lang_check('After delete, template changes needed')?></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php echo lang('Visible in frontend')?></label>
                      <div class="col-lg-9">
                        <?php echo form_checkbox('is_frontend', '1', $this->input->post('is_frontend') ? $this->input->post('is_frontend') : $option->is_frontend)?>
                      </div>
                    </div>

                    <div class="form-group IS-INPUTBOX">
                      <label class="col-lg-3 control-label"><?php echo lang_check('Max length')?></label>
                      <div class="col-lg-9">
                        <?php echo form_input('max_length', $this->input->post('max_length') ? $this->input->post('max_length') : $option->max_length, 'class="form-control"')?>
                      </div>
                    </div>

                    <div class="form-group NOT-TREE NOT-UPLOAD NOT-CATEGORY">
                      <label class="col-lg-3 control-label"><?php echo lang_check('Required')?></label>
                      <div class="col-lg-9">
                        <?php echo form_checkbox('is_required', '1', $this->input->post('is_required') ? $this->input->post('is_required') : $option->is_required)?>
                        <span class="label label-info"><?php echo lang_check('Not available for all field types')?></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label"><?php _l('Visible in quick submission')?></label>
                      <div class="col-lg-9">
                        <?php echo form_checkbox('is_quickvisible', '1', $this->input->post('is_quickvisible') ? $this->input->post('is_quickvisible') : $option->is_quickvisible)?>
                        <span class="label label-info"><?php _l('Not available for all field types')?></span>
                      </div>
                    </div>

                    <?php if(!empty($option->id) && in_array($option->type, array('INPUTBOX', 'DECIMAL', 'INTEGER','DATETIME'))): ?>
                    <?php if (!$this->db->field_exists("field_".$option->id."_int", 'property_lang')): ?>
                    <div class="form-group NOT-TREE NOT-UPLOAD NOT-CATEGORY">
                      <label class="col-lg-3 control-label"></label>
                      <div class="col-lg-9">
                        <a href="<?php echo site_url('admin/estate/numeric_field_range/'.$option->id.'/'.$option->type); ?>" class="btn btn-primary-blue"><?php echo lang_check('Enable numerical filtering')?></a>

                        <span class="label label-info"><?php echo lang_check('Not available for all field types')?></span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>

                    <hr />
                    <h5><?php echo lang('Translation data')?></h5>
                    <div style="margin-bottom: 18px;" class="tabbable">
                      <ul class="nav nav-tabs">
                        <?php $i=0;foreach($this->option_m->languages as $key=>$val):$i++;?>
                        <li class="<?php echo $i==1?'active':''?>"><a data-toggle="tab" href="#<?php echo $key?>"><?php echo $val?></a></li>
                        <?php endforeach;?>
                      </ul>
                      <div style="padding-top: 25px;" class="tab-content">
                        <?php $i=0;foreach($this->option_m->languages as $key=>$val):$i++;?>
                        <div id="<?php echo $key?>" class="tab-pane <?php echo $i==1?'active':''?>">
                            <div class="form-group">
                              <label class="col-lg-3 control-label"><?php echo lang('Option name')?></label>
                              <div class="col-lg-9">
                                <?php echo form_input('option_'.$key, set_value('option_'.$key, $option->{"option_$key"}), 'class="form-control" id="inputOption_'.$key.'" placeholder="'.lang('Option name').'"')?>
                              </div>
                            </div>
                            <div class="form-group NOT-TREE">
                              <label class="col-lg-3 control-label"><?php echo lang_check('Values (Without spaces)')?></label>
                              <div class="col-lg-9">
                                <?php echo form_input('values_'.$key, set_value('values_'.$key, $option->{"values_$key"}), 'class="form-control" id="inputValues_'.$key.'" placeholder="'.lang('Values').'"')?>
                              </div>
                            </div>
                            <?php if(config_item('tree_field_enabled') === TRUE): ?>
                            <div class="form-group IS-TREE">
                              <label class="col-lg-3 control-label"><?php echo lang_check('Values (Without spaces)')?></label>
                              <div class="col-lg-9">
                                <?php if(empty($option->id)): ?>
                                <p class="label label-warning"><?php echo lang_check('Available after saving'); ?></p>
                                <?php else: ?>
                                <a href="<?php echo site_url('admin/treefield/edit/'.$option->id); ?>" class="tree-values btn btn-primary-blue"><?php echo lang_check('Edit tree values')?></a>
                                <?php endif; ?>
                              </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                              <label class="col-lg-3 control-label"><?php echo lang_check('Prefix')?></label>
                              <div class="col-lg-9">
                                <?php echo form_input('prefix_'.$key, set_value('prefix_'.$key, $option->{"prefix_$key"}), 'class="form-control" id="inputPrefix_'.$key.'" placeholder="'.lang_check('Prefix').'"')?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-3 control-label"><?php echo lang('Suffix')?></label>
                              <div class="col-lg-9">
                                <?php echo form_input('suffix_'.$key, set_value('suffix_'.$key, $option->{"suffix_$key"}), 'class="form-control" id="inputSuffix_'.$key.'" placeholder="'.lang('Suffix').'"')?>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-lg-3 control-label"><?php echo lang('Hint')?></label>
                              <div class="col-lg-9">
                                <?php echo form_input('hint_'.$key, set_value('hint_'.$key, $option->{"hint_$key"}), 'class="form-control" id="inputHint_'.$key.'" placeholder="'.lang('Hint').'"')?>
                              </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                      </div>
                    </div>
<div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-3 col-lg-9">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/estate/options')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
           <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<?php if(config_db_item('field_file_upload_enabled') === TRUE): ?>
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
            <?php if(!isset($option->id)):?>
            <span class="label label-danger"><?php echo lang('After saving, you can add files and images');?></span>
            <?php else:?>
            <p>By order, first image will be used as profile and second as agency logo.</p>
            <div class="page-files-box" id="page-files-<?php echo $option->id?>" rel="option_m">
                <!-- The file upload form used as target for the file upload widget -->
                <form class="fileupload" action="<?php echo site_url('files/upload_field_icons/'.$option->id);?>" method="POST" enctype="multipart/form-data">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value="<?php echo site_url('admin/estate/edit_option/'.$option->id);?>"></noscript>
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
                        <?php if(isset($files[$option->repository_id]))foreach($files[$option->repository_id] as $file ):?>
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
<?php endif;?>


<script language="javascript">

/* 
    For custom field type elements, hide/show feature
    
    Example usage:
    css class: NOT-TREE, IS-TREE
    <div class="form-group NOT-TREE">
    <div class="form-group IS-TREE">
*/

$(document).ready(function() {
    reset_field_visibility();
    
    var field_type = $("select[name=type]").val();
    $(".NOT-"+field_type).hide();
    $(".IS-"+field_type).show();
        
    $("select[name=type]").change(function(){
        reset_field_visibility();
        
        var field_type = $(this).val();
        $(".NOT-"+field_type).hide();
        $(".IS-"+field_type).show();
    });
});

function reset_field_visibility()
{
    $("select[name=type] option" ).each(function( index ) {
        var field_type = $( this ).attr('value');
        
        $(".NOT-"+field_type).show();
        $(".IS-"+field_type).hide();
    });
}

</script>

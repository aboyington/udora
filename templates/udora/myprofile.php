<!DOCTYPE html>
<html>
<head>
    <?php _widget('head'); ?>
    <script src='assets/js/gmap3/gmap3.min.js'></script>
</head>
<body class="dashboard-body">
<?php _widget('header_menu'); ?>
<!-- Add Event -->
<div class="container dashboard-layout" id="main">
    <div class="raw">
        <div class="col-xs-12" style="padding-bottom: 30px;">
            <div class="col-md-3 hidden-xs hidden-sm pad0">
                <?php _widget('custom_login_profile'); ?>
                <?php _widget('custom_loginusermenu');?>
            </div>
            <div class="col-xs-12 col-md-9 pad0">
                <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo lang_check('Edit Profile');?></div>
                        <div class="panel-body left-align">
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="form-group" id="add-event">
                                        <div class="">
                                            <?php echo validation_errors()?>
                                            <?php if($this->session->flashdata('message')):?>
                                            <?php echo $this->session->flashdata('message')?>
                                            <?php endif;?>
                                            <?php if($this->session->flashdata('error')):?>
                                            <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                            <?php endif;?></div>
                                            <?php echo form_open(NULL, array('class' => 'form-horizontal form-estate flabel-anim', 'role'=>'form'))?>                              
                                            
                                            <!-- [Custom fields] -->                       
                                            <?php
                                                $CI =& get_instance(); 
                                                $custom_fields = $CI->data['custom_fields'];
                                                $content_language_id = $CI->data['content_language_id'];
                                                $settings_field = ('custom_fields_code');
                                                $custom_fields_code = $CI->settings_m->get_field($settings_field);
                                                $obj_widgets = json_decode($custom_fields_code);

                                                if(is_object($obj_widgets) && is_object($obj_widgets->PRIMARY))
                                                foreach($obj_widgets->PRIMARY as $key=>$obj)
                                                {
                                                    $title = '';
                                                    $rel = $obj->rel;
                                                    $val = '';
                                                    if(isset($custom_fields->{'cinput_'.$rel}))
                                                        $val = $custom_fields->{'cinput_'.$rel};
                                                    $class_color = $obj->type;
                                                    $label = $obj->{"label_$content_language_id"};

                                                    if(!empty($obj->type))
                                                    {
                                                        if($obj->type === 'INPUTBOX')
                                                        {
                                                ?>

                                                    <div class="form-group">
                                                        <?php echo form_input('cinput_'.$rel, set_value('cinput_'.$rel, _ch($val, '')), 'class="form-control" id="input_facebook_link" placeholder="'.$label.'"')?>
                                                        <label class="control-label"><?php echo $label; ?></label>
                                                    </div>

                                                <?php
                                                }
                                                else if($obj->type === 'TEXTAREA')
                                                {
                                                ?>

                                                    <div class="form-group">
                                                        <?php echo form_textarea('cinput_'.$rel, set_value('cinput_'.$rel, _ch($custom_fields->{'cinput_'.$rel}, '')), 'class="form-control" id="input_payment_details" placeholder="'.$label.'"')?>
                                                        <label class="control-label"><?php echo $label; ?></label>
                                                    </div>

                                                <?php
                                                }
                                                else if($obj->type === 'CHECKBOX')
                                                {
                                                    ?>

                                                        <div class="form-group">
                                                          <label class="control-label"><?php echo $label; ?></label>
                                                          <div class="controls">
                                                            <?php echo form_checkbox('cinput_'.$rel, '1', set_value('cinput_'.$rel, _ch($custom_fields->{'cinput_'.$rel}, '')), 'id="input_alerts_email"')?>
                                                          </div>
                                                        </div>

                                                    <?php
                                                    }
                                                }
                                            }

                                            ?>          
                                            <!-- [/Custom fields] -->
                                            
                                            <div class="form-group">
                                                <?php echo form_input('name_surname', set_value('name_surname', $user_data['name_surname']), 'class="form-control" id="inputNameSurname" placeholder="'.lang('FirstLast').'"')?>
                                                  <label for="inputNameSurname" class="control-label"><?php echo lang('FirstLast')?></label>
                                            </div>

                                            <div class="form-group">
                                                    <?php echo form_input('username', set_value('username', $user_data['username']), 'class="form-control" id="inputUsername" placeholder="'.lang('Username').'"')?>
                                                    <label for="inputUsername" class="control-label"><?php echo lang('Username')?></label>
                                            </div>
                                        
                                            <div class="form-group">
                                                    <?php echo form_input('mail', set_value('mail', $user_data['mail']), 'class="form-control" id="inputEmail" placeholder="'.lang('Email').'"')?>
                                                    <label for="inputEmail" class="control-label"><?php echo lang('Email')?></label>
                                            </div>

                                            <div class="form-group">
                                                <?php echo form_password('password', set_value('password', ''), 'class="form-control" id="inputPassword" autocomplete="off" placeholder="'.lang('Password').'"')?>
                                              <label for="inputPassword" class="control-label"><?php echo lang('Password')?></label>
                                            </div>

                                            <div class="form-group">
                                                <?php echo form_password('password_confirm', set_value('password_confirm', ''), 'class="form-control" id="inputPasswordConfirm" autocomplete="off" placeholder="'.lang('PasswordConfirm').'"')?>
                                              <label for="inputPasswordConfirm" class="control-label"><?php echo lang('PasswordConfirm')?></label>
                                            </div>
                                            <div class="form-group">
                                                <?php echo form_input('phone', set_value('phone', $user_data['phone']), 'class="form-control" id="inputPhone" placeholder="'.lang('Phone').'"')?>
                                              <label for="inputPhone" class="control-label"><?php echo lang('Phone')?></label>
                                            </div>
                                            <div class="form-group">
                                                <?php echo form_input('address', set_value('address', $user_data['address']), 'placeholder="'.lang('Address').'" id="inputAddress" class="form-control"')?>
                                              <label for="inputAddress" class="control-label"><?php echo lang('Address')?></label>
                                            </div>
<!-- 
                                            <div class="form-group">
                                              <label for="inputDescription" class="control-label"><?php echo lang('Description')?></label>
                                              <div class="controls">
                                                <?php echo form_textarea('description', set_value('description', $user_data['description']), 'placeholder="'.lang('Description').'" rows="3" id="inputDescription" class="form-control"')?>
                                              </div>
                                            </div>
 -->
                                            <div class="form-group form-footer">
                                                <?php echo form_submit('submit', lang('Save'), 'class="btn btn-action-accept"')?>
                                            </div>
                                        <?php echo form_close()?>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="profile-uiploadimage">
                                    <?php if(!isset($user_data['id'])):?>
                                        <span class="label label-danger"><?php echo lang_check('After saving, you can add files and images');?></span>
                                    <?php else:?>
                                        <div id="page-files-<?php echo $user_data['id']?>" rel="user_m">
                                            <!-- The file upload form used as target for the file upload widget -->
                                            <form class="fileupload-custom" action="<?php echo site_url('files/upload_user/'.$user_data['id']);?>" method="POST" enctype="multipart/form-data">
                                                <div role="presentation" class="fieldset-content">
                                                    <ul class="files files-list-u clearfix" data-toggle="modal-gallery" data-target="#modal-gallery">      
                                                    <?php if(isset($files[$user_data['repository_id']]))foreach($files[$user_data['repository_id']] as $file ):?>
                                                        <li class="img-rounded template-download fade in">
                                                            <div class="preview">
                                                                <img class="img-rounded" alt="<?php echo $file->filename?>" data-src="<?php echo $file->thumbnail_url?>" src="<?php echo $file->thumbnail_url?>">
                                                            </div>
                                                            <div class="filename">
                                                                <code><?php echo character_hard_limiter($file->filename, 20)?></code>
                                                            </div>
                                                            <div class="options-container">

                                                                <?php if($file->zoom_enabled):?>
                                                               <!--  <a data-gallery="gallery" href="<?php echo $file->download_url?>" title="<?php echo $file->filename?>" download="<?php echo $file->filename?>" class="zoom-button btn btn-mini btn-success"><i class="icon-search icon-white"></i></a>                  
                                                                <a class="btn btn-mini btn-info iedit visible-inline-block-lg" rel="<?php echo $file->filename?>" href="#<?php echo $file->filename?>"><i class="icon-pencil icon-white"></i></a> -->
                                                                <?php else:?>
                                                                <a target="_blank" href="<?php echo $file->download_url?>" title="<?php echo $file->filename?>" download="<?php echo $file->filename?>" class="btn btn-mini btn-success"><i class="icon-search icon-white"></i></a>
                                                                <?php endif;?>
                                                                <span class="delete hidden">
                                                                    <button class="btn btn-mini btn-danger" data-type="POST" data-url="<?php echo $file->delete_url?>"><i class="icon-trash icon-white"></i></button>
                                                                    <input type="checkbox" value="1"  checked name="delete">
                                                                </span>

                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                    </ul>
                                                </div>
                                                 <p style="width:100%;max-width: 195px;margin: 0 auto 15px auto;font-size: 12px;">*Profile pictures taken in portrait mode are not supported at this time</p>
                                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                <noscript><input type="hidden" name="redirect" value="<?php echo site_url('frontend/myprofile/'.$lang_code);?>"></noscript>
                                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                <div class="fileupload-buttonbar row">
                                                    <div class="col-md-12">
                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                        <span class="btn btn-success fileinput-button">
                                                            <i class="material-icons">unarchive</i>
                                                            <input type="file" name="files[]" multiple>
                                                        </span>
                                                        <button type="reset" class="btn btn-warning cancel">
                                                            <i class="icon-ban-circle icon-white"></i>
                                                            <span><?php echo lang_check('Cancelupload')?></span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger delete">
                                                            <i class="material-icons">delete_forever</i>
                                                        </button>
                                                        <input type="checkbox" class="toggle hidden" />
                                                    </div>
                                                    <!-- The global progress information -->
                                                    <div class="col-md-12 fileupload-progress fade">
                                                        <!-- The global progress bar -->
                                                        <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                            <div class="bar" style="width:0%;"></div>
                                                        </div>
                                                        <!-- The extended global progress information -->
                                                        <div class="progress-extended">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <div class="fileupload-loading"></div>
                                            </form>
                                        </div>
                                    <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 d-block d-md-none pad0">
                <?php _widget('custom_login_profile'); ?>
                <?php _widget('custom_loginusermenu');?>
            </div>



        </div>
    </div>
</div>
<div class="d-block d-md-none">
    <?php _widget('custom_footer_menu');?>
</div>

<a href="#" class="js-toogle-footermenu">
    <i class="material-icons">
    playlist_add
    </i>
    <i class="close-icon"></i>
</a>
<div class="d-none d-sm-block">
    <?php _widget('custom_footer'); ?>
</div>

<?php _widget('custom_javascript'); ?>
<script>
    $(document).ready(function(){
        /*$('body').append('<div id="blueimp-gallery" class="blueimp-gallery">\n\
                            <div class="slides"></div>\n\
                            <h3 class="title"></h3>\n\
                            <a class="prev">&lsaquo;</a>\n\
                            <a class="next">&rsaquo;</a>\n\
                            <a class="close">&times;</a>\n\
                            <a class="play-pause"></a>\n\
                            <ol class="indicator"></ol>\n\
                            </div>')*/
        
        
    $('form.fileupload-custom').each(function () {
            $(this).fileupload({
            <?php if(config_item('app_type') != 'demo'):?>
            autoUpload: true,
            <?php endif;?>
            // The maximum width of the preview images:
            previewMaxWidth: 160,
            // The maximum height of the preview images:
            previewMaxHeight: 120,
            uploadTemplateId: null,
            downloadTemplateId: null,
            uploadTemplate: function (o) {
                var rows = $();
                $.each(o.files, function (index, file) {
                    /*
                    var row = $('<li class="img-rounded template-upload">' +
                        '<div class="preview"><span class="fade"></span></div>' +
                        '<div class="filename"><code>'+file.name+'</code></div>'+
                        '<div class="options-container">' +
                        '<span class="cancel"><button  class="btn btn-mini btn-warning"><i class="icon-ban-circle icon-white"></i></button></span></div>' +
                        (file.error ? '<div class="error"></div>' :
                                '<div class="progress">' +
                                    '<div class="bar" style="width:0%;"></div></div></div>'
                        )+'</li>');
                    row.find('.name').text(file.name);
                    row.find('.size').text(o.formatFileSize(file.size));
                    if (file.error) {
                        row.find('.error').text(
                            locale.fileupload.errors[file.error] || file.error
                        );
                    }
                    */
                    var row = $('<div> </div>');
                    rows = rows.add(row);
                });
                return rows;
            },
            downloadTemplate: function (o) {
                var rows = $();
                $.each(o.files, function (index, file) {
                    var row = $('<li class="img-rounded template-download fade">' +
                        '<div class="preview"><span class="fade"></span></div>' +
                        '<div class="filename"><code>'+file.short_name+'</code></div>'+
                        '<div class="options-container">' +
                        (file.zoom_enabled?
                            '<a data-gallery="gallery" class="zoom-button btn btn-mini btn-success" download="'+file.name+'"><i class="icon-search icon-white"></i></a>'
                            : '<a target="_blank" class="btn btn-mini btn-success" download="'+file.name+'"><i class="icon-search icon-white"></i></a>') +
                        ' <span class="delete"><button class="btn btn-mini btn-danger hidden" data-type="'+file.delete_type+'" data-url="'+file.delete_url+'"><i class="icon-trash icon-white"></i></button>' +
                        ' <input type="checkbox" checked value="1" class="hidden" name="delete"></span>' +
                        '</div>' +
                        (file.error ? '<div class="error"></div>' : '')+'</li>');
                    
                    var added=false;
                    
                    if (file.error) {
                        ShowStatus.show(file.error);
                        
//                        row.find('.name').text(file.name);
//                        row.find('.error').text(
//                            file.error
//                        );
                    } else {
                        added=true;
                        row.find('.name a').text(file.name);
                        if (file.thumbnail_url) {
                            row.find('.preview').html('<img class="img-rounded" alt="'+file.name+'" data-src="'+file.thumbnail_url+'" src="'+file.thumbnail_url+'">');  
                        }
                        row.find('a').prop('href', file.url);
                        row.find('a').prop('title', file.name);
                        row.find('.delete button')
                            .attr('data-type', file.delete_type)
                            .attr('data-url', file.delete_url);
                    }
                    if(added)
                        rows = rows.add(row);
                });
                
                return rows;
            },
            destroyed: function (e, data) {
                $.fn.endLoading();
                <?php if(config_item('app_type') != 'demo'):?>
                if(data.success)
                {
                }
                else
                {
                    ShowStatus.show('<?php echo lang_check('Unsuccessful, possible permission problems or file not exists'); ?>');
                }
                <?php endif;?>
                return false;
            },
            added: function (e, data) {
                $('.profile-uiploadimage .fileupload-buttonbar .delete').trigger('click');
            },
            finished: function (e, data) {
                $('.zoom-button').unbind('click touchstart');
                $('.zoom-button').bind("click touchstart", function()
                {
                    var myLinks = new Array();
                    var current = $(this).attr('href');
                    var curIndex = 0;
                    
                    $('.files-list-u .zoom-button').each(function (i) {
                        var img_href = $(this).attr('href');
                        myLinks[i] = img_href;
                        if(current == img_href)
                            curIndex = i;
                    });
            
                    options = {index: curIndex}
            
                    blueimp.Gallery(myLinks, options);
                    
                    return false;
                });
            },
            dropZone: $(this)
        });
        });       
        
        $("ul.files").each(function (i) {
            $(this).sortable('disable'); 
            $(this).enableSelection();
        });
        
        
    })
    
</script>
</body>
</html>

<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('File editor')?></h3>
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
                <h2><?php echo lang_check('Edit file').' "' . $filename.'"'?></h2>
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
                    <?php echo validation_errors()?>
                    <?php if($this->session->flashdata('message')):?>
                    <?php echo $this->session->flashdata('message')?>
                    <?php endif;?>
                    <?php if($this->session->flashdata('error')):?>
                    <p class="label label-important validation"><?php echo $this->session->flashdata('error')?></p>
                    <?php endif;?>   
                </div>
                <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                    <div class="form-group">
                      <label class="col-lg-2 control-label"><?php echo lang_check('File content')?></label>
                      <div class="col-lg-10">
                        <?php 
                        echo form_textarea('file_content', $file_content, 'placeholder="'.lang_check('File content').'" rows="20" style="height:800px;width:100%;" class="form-control" id="file_content"')?>
                      </div>
                    </div>   
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                        <a href="<?php echo site_url('admin/templatefiles')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                      </div>
                    </div>
               <?php echo form_close()?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('adminudora-assets/js/codemirror/lib/codemirror.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('adminudora-assets/js/codemirror/lib/codemirror.css'); ?>">
<script src="<?php echo base_url('adminudora-assets/js/codemirror/mode/javascript/javascript.js'); ?>"></script>

<script src="<?php echo base_url('adminudora-assets/js/codemirror/addon/edit/matchbrackets.js'); ?>"></script>
<script src="<?php echo base_url('adminudora-assets/js/codemirror/mode/htmlmixed/htmlmixed.js'); ?>"></script>
<script src="<?php echo base_url('adminudora-assets/js/codemirror/mode/xml/xml.js'); ?>"></script>
<script src="<?php echo base_url('adminudora-assets/js/codemirror/mode/css/css.js'); ?>"></script>
<script src="<?php echo base_url('adminudora-assets/js/codemirror/mode/clike/clike.js'); ?>"></script>
<script src="<?php echo base_url('adminudora-assets/js/codemirror/mode/php/php.js'); ?>"></script>

<script type="text/javascript">
$(function() {

    var editor = CodeMirror.fromTextArea(document.getElementById("file_content"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "<?php 
        if(substr($filename,-3) == 'css')
        {
            echo 'css';
        }
        elseif(substr($filename,-3) == 'php')
        {
            echo 'application/x-httpd-php';
        }
        elseif(substr($filename,-3) == '.js')
        {
            echo 'javascript';
        }
        
        ?>",
        indentUnit: 4,
        indentWithTabs: true
    });
});
</script>

<style>
.CodeMirror {
  border: 1px solid #eee;
  height: 600px;
}
</style>

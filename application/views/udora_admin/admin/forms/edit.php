<div class="page-title">
    <div class="title_left">
        <h3><?php echo empty($listing->id) ? lang_check('Add form') : lang_check('Edit form').' "' . $listing->id.'"'?></h3>
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
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang('Search forms editor') ?></h2>
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
                <div class="padd-alert">
                    <?php echo validation_errors() ?>
                    <?php if ($this->session->flashdata('message')): ?>
                        <?php echo $this->session->flashdata('message') ?>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error') ?></p>
                    <?php endif; ?>     
                </div>
                <div class="row">
                    <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role'=>'form'))?>                              
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Theme')?></label>
                                  <div class="col-lg-10">
                                    <?php 
                                    
                                    $theme = $this->data['settings']['template'];
                                    
                                    if(config_db_item('loaded_template_config') !== FALSE)
                                        $theme = config_db_item('loaded_template_config');
                                    
                                    echo form_input('theme', $theme, 'class="form-control" readonly=""')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Form name')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_input('form_name', $this->input->post('form_name') ? $this->input->post('form_name') : $listing->form_name, 'placeholder="'.lang_check('Template name').'" class="form-control"')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Type')?></label>
                                  <div class="col-lg-10">
                                    <?php echo form_input('type', 'MAIN', 'class="form-control" readonly=""')?>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-lg-2 control-label"><?php echo lang_check('Fields order primary')?></label>
                                  <div class="col-lg-10">
                                    <?php 
                                    $fields_value_json_1 = set_value('fields_order_primary', $listing->fields_order_primary);
                                    $fields_value_json_1 = htmlspecialchars_decode($fields_value_json_1);
                                    
                                    echo form_textarea('fields_order_primary', $fields_value_json_1, 'placeholder="'.lang_check('Fields order primary').'" rows="2" class="form-control" id="fields_order_json" readonly="" ')?>
                                  </div>
                                </div>   
<div class="ln_solid"></div>
                                <div class="form-group">
                                  <div class="col-lg-offset-2 col-lg-10">
                                    <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                                    <a href="<?php echo site_url('admin/estate/forms')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
                                  </div>
                                </div>
                       <?php echo form_close()?>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="clearfix"></div>

          <div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo lang_check('Drag from here') ?></h2>
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
                <div class="x_conten widget-content">
                  <div class="padd">
<div class="container">
<div class="row">
  <div class="col-md-12">
        <div class="drag_visual_container">
        <table>
            <tr>
                <td class="box header">
                <span>FIELDS</span>
                
<div class="el_drag el_style custom" f_direction="NONE" f_type="DATE_RANGE" f_id="NONE" rel="DATE_RANGE"><?php _l('DATE RANGE'); ?></div>
<div class="el_drag el_style custom" f_direction="NONE" f_type="SMART_SEARCH" f_id="NONE" rel="SMART_SEARCH"><?php _l('SMART SEARCH'); ?></div>
<div class="el_drag el_style custom" f_direction="NONE" f_type="BREAKLINE" f_id="NONE" rel="BREAKLINE"><?php _l('BREAKLINE'); ?></div>
<div class="el_drag el_style custom" f_direction="NONE" f_type="C_PURPOSE" f_id="NONE" rel="C_PURPOSE"><?php _l('C_PURPOSE'); ?></div>
<div class="el_drag el_style custom" f_direction="NONE" f_type="QUICK_SEARCH" f_id="NONE" rel="QUICK_SEARCH"><?php _l('QUICK_SEARCH'); ?></div>

<?php

    $disabled_items = array('UPLOAD', 'TEXTAREA', 'PEDIGREE', 'HTMLTABLE');
    
    if(!file_exists(APPPATH.'controllers/admin/treefield.php'))
    {
        $disabled_items[] = 'TREE';
    }

    foreach($this->fields as $key=>$row)
    {
        if(!in_array($row->type, $disabled_items))
            echo '<div class="el_drag el_style '.$row->type.'" f_direction="NONE" f_type="'.$row->type.'" f_id="'.$row->id.'" rel="'.$row->type.'_'.$row->id.'">#'.$row->id.', '.$row->option.'</div>';
    }          
?>
                </td>
            </tr>
        </table>
        </div>
  </div>

</div>

</div> 
                  </div>
                </div>
                  <div class="widget-foot">

</head>
<style>

.drag_visual_container
{
    width:100%;
    border:1px solid black;
    padding:5px;
    background: white;
    max-width:600px;
    margin:auto;
}

.drag_visual_container table
{
    width:100%;
}

.drag_visual_container .box
{
    border:1px solid #EEEEEE;
    height:40px;
    position: relative;
    vertical-align: top;
}

.drag_visual_container .box span
{
    display:block;
    text-align: center;
    background:#EEEEEE;
}

div.el_style
{
    background: #67BDC4;
    border:1px solid white;
    display:block;
    text-align: center;
    color:white;
    padding:5px;
    margin:2px 2px 2px 2px;
    float:left;
    width:49%;
    z-index: 100;
    cursor:move;
}

div.el_style.ui-draggable-dragging
{
    border:1px solid black;
    cursor: move;
}

div.el_style.custom
{
    background: #699057;
}

div.el_style.CHECKBOX
{
    background: #CC470C;
}

div.el_style.DROPDOWN
{
    background: #1E0D38;
}

div.el_style.INPUTBOX
{
    background: #4C8AB4;
}

div.el_style.DROPDOWN_MULTIPLE
{
    background: #155F86;
}


</style>

                  </div>
              </div>  

            </div>
            <div class="col-md-6">


                <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo lang_check('Drop to here') ?></h2>
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
                <div class="x_conten widget-content">
                  <div class="padd">
<div class="container">
<div class="row">
  <div class="col-md-12">
        <div class="drop_visual_container">
        <table>
            <tr>
                <td class="box PRIMARY" colspan="2"><span class="">PRIMARY</span>
<?php
$obj_widgets = json_decode($fields_value_json_1);

if(is_object($obj_widgets->PRIMARY))
foreach($obj_widgets->PRIMARY as $key=>$obj)
{
    $title = '';
    $rel = $obj->type;
    $class_color = $obj->type;
    $direction = 'NONE';
    if($obj->id != 'NONE')
    {
        if(isset($this->fields[$obj->id]))
        {
            $title.='#'.$obj->id.', ';
            $title.=$this->fields[$obj->id]->option;
            $rel = $this->fields[$obj->id]->type.'_'.$obj->id;
            
            if($obj->direction != 'NONE')
            {
                $direction = $obj->direction;
                $title.=', '.$direction;
                $rel.='_'.$obj->direction;
            }
        }
    }
    else
    {
        $title.=lang_check($obj->type);
        $class_color='custom';
    }

    if(!empty($title))
    echo '<div class="el_sort el_style '.$class_color.'" f_style="'.$obj->style.'" f_class="'.$obj->class.'" f_direction="'.$direction.'" f_type="'.$obj->type.'" f_id="'.$obj->id.'" rel="'.$rel.'" style="width:100%;"><span>'.$title.
         '</span><a href="#test-form" target="_blank" class="btn btn-primary-blue btn-xs popup-with-form"><i class="icon-edit"></i></a>'.
         '<button type="button" class="btn btn-danger btn-xs"><i class="icon-remove"></i></button></div>';
}
?>
                </td>
            </tr>
            <tr>
                <td class="box SECONDARY" colspan="2"><span class="">SECONDARY</span>
<?php
$obj_widgets = json_decode($fields_value_json_1);

if(is_object($obj_widgets->SECONDARY))
foreach($obj_widgets->SECONDARY as $key=>$obj)
{
    $title = '';
    $rel = $obj->type;
    $class_color = $obj->type;
    $direction = 'NONE';
    if($obj->id != 'NONE')
    {
        if(isset($this->fields[$obj->id]))
        {
            $title.='#'.$obj->id.', ';
            $title.=$this->fields[$obj->id]->option;
            $rel = $this->fields[$obj->id]->type.'_'.$obj->id;
            
            if($obj->direction != 'NONE')
            {
                $direction = $obj->direction;
                $title.=', '.$direction;
                $rel.='_'.$obj->direction;
            }
        }
    }
    else
    {
        $title.=lang_check($obj->type);
        $class_color='custom';
    }

    if(!empty($title))
    echo '<div class="el_sort el_style '.$class_color.'" f_style="'.$obj->style.'" f_class="'.$obj->class.'" f_direction="'.$direction.'" f_type="'.$obj->type.'" f_id="'.$obj->id.'" rel="'.$rel.'" style="width:100%;"><span>'.$title.
         '</span><a href="#test-form" target="_blank" class="btn btn-primary-blue btn-xs popup-with-form"><i class="icon-edit"></i></a>'.
         '<button type="button" class="btn btn-danger btn-xs"><i class="icon-remove"></i></button></div>';
}
?>
                </td>
            </tr>

        </table>
        </div>
    </div>
</div>



</div> 
                  </div>
                </div>
                  <div class="widget-foot">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('adminudora-assets/js/magnific-popup/magnific-popup.css')?>" /> 
<script src="<?php echo base_url('adminudora-assets/js/magnific-popup/jquery.magnific-popup.js')?>"></script> 
<script>

$(function() {
    
    $('#widgets_order_json').val('<?php echo $fields_value_json; ?>');
    
    $( ".el_drag" ).draggable({
        revert: "invalid",
        zIndex: 9999,
        helper: "clone"
    });
    
    <?php $widget_positions = array('PRIMARY', 'SECONDARY');
          foreach($widget_positions as $position_box): ?>
    
    $( ".box.<?php echo $position_box; ?>" ).sortable({items: "div.el_sort"});
    

    
    $(".drop_visual_container .box.<?php echo $position_box; ?>" ).droppable({
      accept: ".el_drag",
      activeClass: "ui-state-hover",
      hoverClass: "ui-state-active",
      drop: function( event, ui ) {
        var exists = false;
        
        jQuery.each($('.el_sort'), function( i, val ) {
            if(ui.draggable.attr('rel') == $(this).attr('rel') && ui.draggable.attr('rel') != 'BREAKLINE')
            {
                exists = true;
            }
        });
        
        if(exists)
        {
            ShowStatus.show('<?php echo lang_check('Already added'); ?>');
            return;   
        }
        
        <?php if($position_box == 'SECONDARY'): ?>
        
        if(ui.draggable.attr('f_type') != 'INPUTBOX' && ui.draggable.attr('f_type') != 'DROPDOWN' && 
           ui.draggable.attr('f_type') != 'CHECKBOX' && ui.draggable.attr('f_type') != 'BREAKLINE' &&
           ui.draggable.attr('f_type') != 'DROPDOWN_MULTIPLE')
        {
            
            //console.log(ui.draggable.attr('f_type'));
            
            ShowStatus.show('<?php echo lang_check('Supported only for PRIMARY form'); ?>');
            return;   
        }
        
        <?php endif; ?>
        
        var new_el = ui.draggable.clone();
        new_el.css('top', 'auto');
        new_el.css('left', 'auto');
        new_el.css('width', '100%');
        new_el.removeClass('el_drag');
        new_el.addClass('el_sort');
        new_el.attr('f_style', '');
        new_el.attr('f_class', '');
        new_el.html('<span>'+new_el.html()+'</span>');
        new_el.append('<button type="button" class="btn btn-danger btn-xs"><i class="icon-remove"></i></button>');
        new_el.append('<a href="#test-form" class="btn btn-primary-blue btn-xs popup-with-form"><i class="icon-edit"></i></a>');
        
        new_el.clone().appendTo( this );

        $(this).sortable("refresh"); 
        
        $('.drop_visual_container .box .btn-danger').click(function(){
           $(this).parent().remove();
           save_json_changes();
        });
        
        save_json_changes();
      }
    }).sortable({
      update: function( event, ui ) {
        save_json_changes();
      },
      items: "div.el_sort"
    });
    <?php endforeach;?>
    
    $('.drop_visual_container .box .btn-danger').click(function(){
       $(this).parent().remove();
       save_json_changes();
    });
    
    define_popup_trigers();
    
    $('#unhide-agent-mask').click(function(){
        
        var data = $('#test-form').serializeArray();

        $('.el_sort[rel='+data[0].value+']').attr('f_style', filterInput(data[1].value));
        $('.el_sort[rel='+data[0].value+']').attr('f_class', filterInput(data[2].value));
        $('.el_sort[rel='+data[0].value+']').attr('f_direction', data[3].value);

        var res = data[0].value.split("_");
        var res2 = $('.el_sort[rel='+data[0].value+'] span').html().split(", ");
        
        if(data[3].value != 'NONE')
        {
            if($('.el_sort[rel='+data[0].value+']').attr('f_id') != 'NONE')
            {
                $('.el_sort[rel='+data[0].value+'] span').html(res2[0]+', '+res2[1]+', '+data[3].value);
            }
            else
            {
                $('.el_sort[rel='+data[0].value+'] span').html(res2[0]+', '+data[3].value);
            }
            
            $('.el_sort[rel='+data[0].value+']').attr('rel', res[0]+'_'+res[1]+'_'+data[3].value);
            
        }
        else
        {
            if($('.el_sort[rel='+data[0].value+']').attr('f_id') != 'NONE')
            {
                $('.el_sort[rel='+data[0].value+'] span').html(res2[0]+', '+res2[1]);
            }
            else
            {
                $('.el_sort[rel='+data[0].value+'] span').html(res2[0]);
            }
            
            $('.el_sort[rel='+data[0].value+']').attr('rel', res[0]+'_'+res[1]);
        }
        
        save_json_changes();

        // Display agent details
        //$('.popup-with-form').css('display', 'none');
        // Close popup
        $.magnificPopup.instance.close();

        return false;
    });
    
});

function filterInput(input){
    return input.replace(/[^a-zA-Z0-9:;-]/g, '');
}

function define_popup_trigers()
{
    $('.popup-with-form').magnificPopup({
    	type: 'inline',
    	preloader: false,
    	focus: '#inputStyle',
                        
    	// When elemened is focused, some mobile browsers in some cases zoom in
    	// It looks not nice, so we disable it:
    	callbacks: {
    		beforeOpen: function() {
    			if($(window).width() < 700) {
    				this.st.focus = false;
    			} else {
    				this.st.focus = '#inputStyle';
    			}
    		},
            
    		open: function() {
                var magnificPopup = $.magnificPopup.instance,
                cur = magnificPopup.st.el.parent();
                
                $('#inputRel').val(cur.attr('rel'));
                $('#inputStyle').val(cur.attr('f_style'));
                $('#inputClass').val(cur.attr('f_class'));
                $('#inputDirection').val(cur.attr('f_direction'));
                
    		}
    	}
    });
}

function save_json_changes()
{
    var js_gen = '{ ';
    <?php foreach($widget_positions as $position_box): ?>
    js_gen+= ' "<?php echo $position_box; ?>": {  ';
    
    jQuery.each($(".drop_visual_container .box.<?php echo $position_box; ?> div"), function( i, val ) {
       if($(this).attr('rel'))
        js_gen+= '"'+$(this).attr('rel')+'":{"direction":"'+$(this).attr('f_direction')+'", "style":"'
                    +$(this).attr('f_style')+'", "class":"'+$(this).attr('f_class')+'", "id":"'+$(this).attr('f_id')
                    +'", "type":"'+$(this).attr('f_type')+'"} ,';
    });
    
    js_gen = js_gen.slice(0,-2);
        
    js_gen+= ' },';
    <?php endforeach; ?>
    js_gen = js_gen.slice(0,-1);
    js_gen+= ' }';
    
    $('#fields_order_json').val(js_gen);
    
    define_popup_trigers();
}

</script>

<style>

.drop_visual_container
{
    width:100%;
    border:1px solid black;
    padding:5px;
    background: white;
    max-width:600px;
    margin:auto;
}

.drop_visual_container table
{
    width:100%;
}

.drop_visual_container .box
{
    border:1px solid #EEEEEE;
    height:200px;
    position: relative;
    vertical-align: top;
}

.drop_visual_container .box.bottom,
.drop_visual_container .box.footer,
.drop_visual_container .box.header
{
    height:100px;
}

.drop_visual_container .box span
{
    display:block;
    text-align: center;
    background:#EEEEEE;
}

.drop_visual_container .box .el_sort span
{
    background:none;
}

.drop_visual_container .box div
{
    position:relative;
}

.drop_visual_container .box .btn-danger
{
    right:5px;
    position:absolute;
    top:5px;
}

.drop_visual_container .box .btn-success
{
    right:28px;
    position:absolute;
    top:5px;
}

<?php if(config_db_item('secondary_disabled') === TRUE): ?>
td.box.SECONDARY
{
    display:none;
} 
<?php endif; ?>

</style>

                  </div>
              </div>  

            </div>
</div>

        </div>
		  </div>
          
<!-- form itself -->
<form id="test-form" class="form-horizontal mfp-hide white-popup-block">
    <div id="popup-form-validation">
    <p class="hidden alert alert-error"><?php echo lang_check('Submit failed, please populate all fields!'); ?></p>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputRel"><?php echo lang_check('Rel'); ?></label>
        <div class="controls">
            <input type="text" name="rel" id="inputRel" value="" placeholder="<?php echo lang_check('Rel'); ?>" readonly>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputStyle"><?php echo lang_check('Style'); ?></label>
        <div class="controls">
            <input type="text" name="style" id="inputStyle" value="" placeholder="<?php echo lang_check('Style'); ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputClass"><?php echo lang_check('Class'); ?></label>
        <div class="controls">
            <input type="text" name="class" id="inputClass" value="" placeholder="<?php echo lang_check('Class'); ?>">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="inputDirection"><?php echo lang_check('Direction'); ?></label>
        <div class="controls">
        <select name="direction" id="inputDirection">
            <option value="NONE"><?php _l('NONE'); ?></option>
            <option value="FROM"><?php _l('FROM'); ?></option>
            <option value="TO"><?php _l('TO'); ?></option>
        </select> 
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button id="unhide-agent-mask" type="button" class="btn btn-primary-blue"><?php echo lang_check('Submit'); ?></button>
            <img id="ajax-indicator-masking" src="assets/img/ajax-loader.gif" style="display: none;" />
        </div>
    </div>
</form>
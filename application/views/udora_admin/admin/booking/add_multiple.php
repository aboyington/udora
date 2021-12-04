<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Add multiple reservations'); ?></h3>
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
                <h2><?php echo lang_check('Reservations data')?></h2>
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
                          <label class="col-lg-2 control-label"><?php echo lang_check('User')?></label>
                          <div class="col-lg-10">
                            <?php echo form_dropdown('user_id', $users, $this->input->post('user_id') ? $this->input->post('user_id') : '', 
                                                     'class="form-control"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Property')?></label>
                          <div class="col-lg-10">
                            <?php echo form_dropdown('property_id', $properties, $this->input->post('property_id') != '' ? $this->input->post('property_id') : '', 
                                                     'class="form-control" id="property_id"')?>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-lg-2 control-label"><?php echo lang_check('Dates')?></label>
                          <div class="col-lg-10">
                            <?php echo form_textarea('dates', $this->input->post('dates') != '' ? $this->input->post('dates') : '', 
                                                     'id="dates_list" placeholder="'.lang_check('Dates').'" rows="3" class="form-control" readonly')?>
                          </div>
                        </div>       

                        <div class="ln_solid"></div>

                        <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                            <?php echo form_submit('submit', lang('Save'), 'class="btn btn-primary-blue"')?>
                            <a href="<?php echo site_url('admin/booking')?>" class="btn btn-danger" type="button"><?php echo lang('Cancel')?></a>
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
                <h2><?php echo lang_check('Calendar')?></h2>
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
                <div class="padd">
                    <div class="av_calender">
                    <?php
                        $row_break=0;
                        
                        foreach($months_availability as $v_month)
                        {
                            echo $v_month;
                            
                            $row_break++;
                            if($row_break%3 == 0)
                            echo '<div style="clear: both;height:10px;"></div>';
                        }
                    ?>
                    <br style="clear: both;" />
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>

table.av_calender a.selected_date{
    background: orange;
}

table.av_calender a.selected_date_temp{
    background: violet;
}

table.av_calender a.disabled
{
    text-decoration: line-through;
    background: black;
}


</style>

<script>

var state_range = 0;
var selectableDatesItem;
var start_index = 0;
var end_index = 0;
var end_index_temp = 0;

$(document).ready(function(){
    
    selectableDatesItem = $('a.selectable');

    $("#property_id").change(function() {

        $.post("<?php echo site_url('privateapi'); ?>/load_reservations/"+$(this).val(), [], 
               function(data){
            
            $.each( data.existing_dates, function( key, value ) {
                //console.log(value);
                $('a[ref='+value+']').addClass('disabled');
            });

        });
        
    });
    
    $('a.selectable').click(function(){
        if(state_range == 0)
        {
            start_index = selectableDatesItem.index(this);
            $(this).addClass('selected_date_temp');
            state_range = 1;
        }
        else
        {
            end_index = selectableDatesItem.index(this);
            
            selectableDatesItem.each(function(index, value){
                if(end_index > start_index)
                {
                    if(index >= start_index && index <= end_index)
                    {
                        if($(this).hasClass('selected_date'))
                        {
                            $(this).removeClass('selected_date')
                        }
                        else
                        {
                            $(this).addClass('selected_date');
                        }
                    }
                }
                else
                {
                    if(index >= end_index && index <= start_index)
                    {
                        if($(this).hasClass('selected_date'))
                        {
                            $(this).removeClass('selected_date')
                        }
                        else
                        {
                            $(this).addClass('selected_date');
                        }
                    }
                }
            });
            
                
            state_range = 0;
            
            selectableDatesItem.each(function(index, value){
                $(this).removeClass('selected_date_temp');
            });
            
            $('a.disabled').removeClass('selected_date');
            
            refresh_dates();
        }
        
        return false;
    });
    
    $("a.selectable").mouseover(function() {
        end_index_temp = selectableDatesItem.index(this);
        
        if(state_range == 1)
        selectableDatesItem.each(function(index, value){
            if(end_index_temp > start_index)
            {
                if(index >= start_index && index <= end_index_temp)
                {
                    $(this).addClass('selected_date_temp');
                }
                else
                {
                    $(this).removeClass('selected_date_temp');
                }
            }
            else
            {
                if(index >= end_index_temp && index <= start_index)
                {
                    $(this).addClass('selected_date_temp');
                }
                else
                {
                    $(this).removeClass('selected_date_temp');
                }
            }
        });
    });
    

    $('#dates_list').val('');
    if($("#property_id").val() != '')
    {
        $("#property_id").trigger("change");
    }
    
});

function refresh_dates()
{
    $('#dates_list').val('');
    
    selectableDatesItem.each(function(index, value){
        if($(this).hasClass('selected_date'))
        {
            $('#dates_list').val($('#dates_list').val() + $(this).attr('ref') + "\n");
        }
    });
}

</script>

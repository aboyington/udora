<div class="page-title">
    <div class="title_left">
        <h3><?php echo lang_check('Eventbrite import')?></h3>
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
                <h2><?php echo lang('Import data')?></h2>
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
                        <p class="label label-important validation"><?php echo $this->session->flashdata('error'); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                        <p class="label label-important validation"> <?php echo $error; ?> </p>
                    <?php endif; ?>
                    <?php if (!empty($message)): ?>
                        <p class="label label-important validation"> <?php echo $message; ?> </p>
                    <?php endif; ?>
                </div>
                <!-- Form starts.  -->
                <?php echo form_open(NULL, array('class' => 'form-horizontal', 'role' => 'form')) ?>                              
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Keywords') ?></label>
                         <div class="col-lg-10">
                            <?php echo form_input('event_keywords',  $this->input->post('event_keywords') ? $this->input->post('event_keywords') : '', 'id="input_event_keywords" class="form-control ui-state-valid" placeholder="Keywords"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Event Categories') ?></label>
                         <div class="col-lg-10">
                             <?php echo form_dropdown('event_category', $event_categories, $this->input->post('event_category'), 'class="form-control ui-state-valid" id="selectEvent_category"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Location')?></label>
                         <div class="col-lg-10">
                            <?php echo form_input('location',  $this->input->post('location') ? $this->input->post('location') : '', 'id="input_location" class="form-control ui-state-valid" placeholder="London, United Kingdom"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Eventbrite limit events') ?></label>
                         <div class="col-lg-10">
                             <?php echo form_input('eventful_limit_page',  $this->input->post('eventful_limit_page') ? $this->input->post('eventful_limit_page') : 1, 'class="form-control ui-state-valid"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Eventbrite offset events') ?></label>
                         <div class="col-lg-10">
                             <?php echo form_input('eventful_offset_page',  $this->input->post('eventful_offset_page') ? $this->input->post('eventful_offset_page') : 0, 'class="form-control ui-state-valid"'); ?>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Start Date') ?></label>
                         <div class="col-lg-10">
                            <div class="input-group date myDatepicker_full" id="datetimepicker2">
                                <?php echo form_input('date_start', $this->input->post('date_start') ? $this->input->post('date_start') : '', 'class="form-control" id="input_date_start" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                 </span>
                            </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('End Date') ?></label>
                         <div class="col-lg-10">
                            <div class="input-group date myDatepicker_full" id="datetimepicker2">
                                <?php echo form_input('date_end', $this->input->post('date_end') ? $this->input->post('date_end') : '', 'class="form-control" id="input_date_end" data-format="yyyy-MM-dd hh:mm:ss"'); ?>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                 </span>
                            </div>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Events pages available (50 events per page)')?></label>
                         <div class="col-lg-10">
                             <span id="pages_available" style='margin-top: 10px;display: block;'><span class="label label-danger"><?php echo lang_check('eventful category doesn`t selected');?></span></span>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-lg-2 control-label"><?php echo lang_check('Overwrite existing')?></label>
                         <div class="col-lg-10">
                         <?php echo form_checkbox('overwrite_existing', '1', false, 'id="root_country"')?>
                         </div>
                     </div>
                     <div class="form-group">
                         <div class="col-lg-offset-2 col-lg-10">
                             <?php echo form_submit('submit', lang_check('Import'), 'class="btn btn-primary-blue"') ?>
                             <a href="<?php echo site_url('admin/estate/') ?>" class="btn btn-danger" type="button"><?php echo lang('Cancel') ?></a>
                             <img src="<?php echo base_url('adminudora-assets/img/loading.gif')?>" id="pre_loading_gif"  style="display:none;height: 20px; margin-left: 5px;" alt="" />
                         </div>
                     </div>
                     <?php echo form_close() ?>
            </div>
            <div class="clearfix"></div>
            <div class="widget-foot">
                        <?php if(isset($imports)): ?>                     
                            <p><?php _l('All property'); ?>: <?php echo count($imports);?></p>
                            <p><?php _l('Added new'); ?>: <?php echo count($imports) - $skipped;?></p>
                            <p><?php _l('Overwrite'); ?>: <?php echo  $count_exists_overwrite;?></p>
                            <br/>
                            <p><?php _l('Skipped'); ?>: <?php echo $skipped;?></p>
                            <p><?php _l('Errors'); ?>: <?php echo $skipped-$count_exists;?></p>
                            <p><?php _l('Exists skipped'); ?>: <?php echo $count_exists;?></p>
                            <br/>
                        <?php endif; ?>

                            <?php if (!empty($imports)): ?>
                            <p><?php _l('Update/Import completed'); ?>:</p>
                            <table class="table table-striped">
                                <tr>
                                    <th>#</th>
                                    <th><?php _l('Address'); ?></th>
                                </tr>
                                <?php foreach ($imports as $item): ?>
                                    <tr>
                                        <td><?php echo $item['id']; ?></td>
                                        <td>
                                           <?php if(!empty($item['preview_id'])):?>
                                            <a href="<?php echo site_url('admin/estate/edit/'.$item['preview_id']); ?>"><?php echo $item['address']; ?></a>
                                           <?php else:?>
                                            <?php echo $item['address']; ?>
                                           <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <br />
                            <a class="label label-warning" target="_blank" href="https://www.eventbrite.com/platform/api#/introduction/expansions"><?php _l('Guides'); ?></a>
                            <br /><br />
                        <?php endif; ?>
                    </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function(){
    
    $('#input_event_keywords, #selectEvent_category, #input_location, #input_date_start, #input_date_end').change(function(){

        var data = [];
        data.push({name: 'event_keyword', value: $('#input_event_keywords').val()});
        data.push({name: 'category', value: $('#selectEvent_category').val()});
        data.push({name: 'location', value: $('#input_location').val()});
        data.push({name: 'date_start', value: $('#input_date_start').val()});
        data.push({name: 'date_end', value: $('#input_date_end').val()});
        
        var eventful_categories = $(this).val();
        $('#pre_loading_gif').show();
        $('#pages_available').html('<span class="label label-warning"><?php echo lang_check('please wait, available pages calculation');?></span>');
        $.post("<?php echo site_url('privateapi'); ?>/eventbrite_get_count_pages/",data, function(data){
            
            if(data.success) {
                $('#pages_available').html(data.eventful_get_count_pages);
            } else {
               $('#pages_available').html('<span class="label label-danger"><?php echo lang_check('can`t get available pages');?></span>');
            }
            
            $('#pre_loading_gif').hide();
        });
    })
    
    $('#selectEvent_category').trigger('change');
})


</script>

<script>
    $(document).ready(function () {
        $('#selcect_deselect_chackbox').click(function (e) {
            e.preventDefault();
            $(".check-box-places").prop('checked', $(this).attr('data-status'));

            if ($(this).attr('data-status') == 'checked') {
                $(this).attr('data-status', '')
            } else {
                $(this).attr('data-status', 'checked')
            }
        })
    })
</script>

<style type="text/css">
    .table.table-striped td {
        font-size: 14px;
        vertical-align: middle;
    }
    
    .table.table-striped td a:hover {
        text-decoration: underline!important;
    }
    
</style>
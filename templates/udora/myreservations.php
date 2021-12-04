<!DOCTYPE html>
<html>
    <head>
        <?php _widget('head'); ?>
    </head>
    <body class="body-login-register"  id="main">
        <?php _widget('header_menu'); ?>
        <!-- Business hero  -->
        <div class="container register-login">
            <div class="raw">
                <div class="col-xs-12">
                    <div class="col-xs-12 col-md-12 box-white section section-d12">
                        <div class="section-title">
                            <h3>{lang_Myreservations}</h3>
                        </div>
                        <div class="">
                            <table class="table table-striped footable">
                                <thead>
                                    <th>#</th>
                                    <th><?php echo lang('Dates');?></th>
                                    <!-- Dynamic generated -->
                                    <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                    <th data-breakpoints="xs sm md"  data-type="html"><?php echo $row->option?></th>
                                    <?php endforeach;?>
                                    <!-- End dynamic generated -->
                                    <th class="control" style="width: 120px;" data-type="html"><?php echo lang('Edit');?></th>
                                    <th class="control" data-type="html"><?php echo lang('Delete');?></th>
                                </thead>
                                <tbody>
                                    <?php if(count($estates)): foreach($estates as $estate):?>
                                    <tr>
                                        <td><?php echo $estate->id?></td>
                                        <td>
                                        <?php echo anchor('frontend/viewreservation/'.$lang_code.'/'.$estate->id, date('Y-m-d', strtotime($estate->date_from)).' - '.date('Y-m-d', strtotime($estate->date_to)))?>
                                        <?php if($estate->is_confirmed == 0):?>
                                        &nbsp;<span class="label label-important"><?php echo lang_check('Not confirmed')?></span>
                                        <?php else: ?>
                                        &nbsp;<span class="label label-success"><?php echo lang_check('Confirmed')?></span>
                                        <?php endif;?>
                                        </td>
                                        <!-- Dynamic generated -->
                                        <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                                        <td>
                                        <?php echo isset($options[$estate->property_id][$row->option_id])?$options[$estate->property_id][$row->option_id]:'-'?></td>
                                        <?php endforeach;?>
                                        <!-- End dynamic generated -->
                                        <td><?php echo anchor('frontend/viewreservation/'.$lang_code.'/'.$estate->id, '<i class="icon-shopping-cart"></i> '.lang_check('View/Pay'), array('class'=>'btn btn-info'))?></td>
                                        <td><?php if($estate->is_confirmed == 0):?><?php echo anchor('frontend/deletereservation/'.$lang_code.'/'.$estate->id, '<i class="icon-remove"></i> '.lang('Delete'), array('onclick' => 'return confirm(\''.lang_check('Are you sure?').'\')', 'class'=>'btn btn-danger'))?><?php endif;?></td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php else:?>
                                        <tr>
                                            <td colspan="20"><?php echo lang_check('No reservations available');?></td>
                                        </tr>
                                    <?php endif;?>      
                                </tbody>
                            </table>
                        </div>
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
            /*
             * http://fooplugins.github.io/FooTable/docs/getting-started.html
             */

            $('document').ready(function () {
                $('.footable').footable({
                    "filtering": {
                        "enabled": false
                    },
                });
            })

        </script>
    </body>
</html>

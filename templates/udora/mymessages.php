<!DOCTYPE html>
<html>
    <head>
        <?php _widget('head'); ?>
    </head>
    <body class="body-login-register">
        <?php _widget('header_menu'); ?>
        <!-- Business hero  -->
        <div class="container register-login">
            <div class="raw">
                <div class="col-xs-12">
                    <div class="col-xs-12 col-md-12 box-white section section-d12">
                        <div class="section-title">
                            <h3><?php _l('My messages'); ?></h3>
                        </div>
                        <div class="">
                            <table class="table table-striped footable" data-sorting="true">
                                <thead>
                                    <th>#</th>
                                    <th data-type="html"><?php _l('Date');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Mail');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Message');?></th>
                                    <th data-breakpoints="xs sm" data-type="html"><?php _l('Estate');?></th>
                                    <th class="control" data-type="html"><?php _l('Edit');?></th>
                                    <th class="control" data-type="html"><?php _l('Delete');?></th>
                                </thead>
                                <?php if(count($listings)): foreach($listings as $listing_item):?>
                                    <tr>
                                        <td><?php echo $listing_item->id; ?>&nbsp;&nbsp;<?php echo $listing_item->readed == 0? '<span class="label label-warning">'.lang_check('Not readed').'</span>':''?></td>
                                        <td><?php echo $listing_item->date; ?></td>
                                        <td><?php echo $listing_item->mail; ?></td>
                                        <td><?php echo $listing_item->message; ?></td>
                                        <td><?php echo $all_estates[$listing_item->property_id]; ?></td>
                                        <td><?php echo btn_edit('fmessages/edit/'.$lang_code.'/'.$listing_item->id)?></td>
                                        <td><?php echo btn_delete('fmessages/delete/'.$lang_code.'/'.$listing_item->id)?></td>
                                    </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr>
                                        <td colspan="20"><?php echo lang_check('We could not find any');?></td>
                                    </tr>
                                <?php endif;?>     
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

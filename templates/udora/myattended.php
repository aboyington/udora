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
                    <?php _widget('custom_loginusermenu'); ?>
                </div>
                <div class="col-xs-12 col-md-9 pad0">
                    <div class="col-xs-12 col-md-12 mobile-pad0 mobile-marg-b-20">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo lang_check('Attend on events'); ?></div>
                            <div class="panel-body left-align">
                                <div class="form-estate">
                                    <?php if(config_db_item('events_qr_confirmation') === TRUE): ?>
                                    <table class="table table-striped footable">
                                        <thead>
                                          <tr>
                                              <th>#</th>
                                              <th><?php echo lang_check('Event name');?></th>
                                              <th><?php echo lang_check('Event address');?></th>
                                              <th data-breakpoints="xs sm"><?php echo lang_check('Attend time');?></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($attend_events) > 0 ): ?>
                                            <?php foreach($attend_events as $key=>$listing): ?>
                                                <tr>
                                                    <td><?php echo $listing->listing_id; ?></td>
                                                    <td><?php echo listing_field($listing, 10); ?></td>
                                                    <td><?php echo $listing->address; ?></td>
                                                    <td><?php echo $listing->date; ?></td>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                                    <tr>
                                                            <td colspan="20"><?php echo lang_check('You didnt attend on event yet');?></td>
                                                    </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
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

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
                            <div class="panel-heading"><?php echo lang_check('My Events'); ?></div>
                            <div class="panel-body left-align">
                                <div class="form-estate">
                                    <?php if($this->session->flashdata('error')):?>
                                    <p class="alert alert-error"><?php echo $this->session->flashdata('error')?></p>
                                    <?php endif;?>
                                    <?php if($this->session->flashdata('message')):?>
                                    <?php echo $this->session->flashdata('message')?>
                                    <?php endif;?>
                                    <table class="table table-striped footable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th data-breakpoints="lg"><?php echo lang('Address'); ?></th>
                                                <!-- Dynamic generated -->
                                                <?php foreach ($this->option_m->get_visible($content_language_id) as $row): ?>
                                                    <th data-hide="phone,tablet"><?php echo $row->option ?></th>
                                                <?php endforeach; ?>
                                                <!-- End dynamic generated -->
                                                <th></th>
                                                <th  data-breakpoints="xs sm md" data-type="html" class="control"><?php echo lang('Edit'); ?></th>
                                                <th  data-breakpoints="xs sm md" data-type="html" class="control"><?php _l('Preview'); ?></th>
                                                <th  data-breakpoints="xs sm md" data-type="html" class="control"><?php echo lang('Delete'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($estates)): foreach ($estates as $estate): ?>
                                                    <tr>
                                                        <td><?php echo $estate->id ?></td>
                                                        <td>
                                                            <?php echo anchor('frontend/editproperty/' . $lang_code . '/' . $estate->id, _ch($estate->address)) ?>
                                                            <?php if ($estate->is_activated == 0): ?>
                                                                &nbsp;<span class="label label-important"><?php echo lang_check('Not activated') ?></span>
                                                            <?php endif; ?>

                                                            <?php if (isset($settings_listing_expiry_days) && $settings_listing_expiry_days > 0 && strtotime($estate->date_modified) <= time() - $settings_listing_expiry_days * 86400): ?>
                                                                &nbsp;<span class="label label-warning"><?php echo lang_check('Expired') ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <!-- Dynamic generated -->
                                                        <?php foreach ($this->option_m->get_visible($content_language_id) as $row): ?>
                                                            <td><?php echo isset($options[$estate->id][$row->option_id]) ? $options[$estate->id][$row->option_id] : '' ?></td>
                                                        <?php endforeach; ?>
                                                        <!-- End dynamic generated -->
                                                        <td>
                                                            <?php if ($estate->is_activated == 0 && $settings_activation_price > 0 && config_db_item('payments_enabled') == 1): ?>
                                                                <div class="btn-group">
                                                                    <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">
                                                                        <?php echo '<i class="icon-shopping-cart"></i> ' . lang('Pay for activation'); ?>
                                                                        <span class="caret"></span>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <?php if (!_empty(config_db_item('paypal_email'))): ?>
                                                                            <li><a href="<?php echo site_url('frontend/do_purchase_activation/' . $lang_code . '/' . $estate->id . '/' . $settings_activation_price); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Pay for activation') . ' ' . lang_check('with PayPal'); ?></a></li>
                                                                        <?php endif; ?>

                                                                        <?php if (file_exists(APPPATH . 'controllers/paymentconsole.php') && !_empty(config_db_item('authorize_api_login_id'))): ?>
                                                                            <li><a href="<?php echo site_url('paymentconsole/authorize_payment/' . $lang_code . '/' . $settings_activation_price . '/' . $settings_default_currency . '/' . $estate->id . '/ACT'); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Pay for activation') . ' ' . lang_check('with CreditCard'); ?></a></li>
                                                                        <?php endif; ?>

                                                                        <?php if (!empty($settings_withdrawal_details) && file_exists(APPPATH . 'controllers/paymentconsole.php')): ?>
                                                                            <li><a href="<?php echo site_url('paymentconsole/invoice_payment/' . $lang_code . '/' . $settings_activation_price . '/' . $settings_default_currency . '/' . $estate->id . '/ACT'); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Buy/Extend') . ' ' . lang_check('with bank payment'); ?></a></li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </div>
                                                            <?php endif; ?>

                                                            <?php if ($estate->is_featured == 0 && $estate->is_activated == 1 && FALSE): ?>
                                                                <?php if ($this->packages_m->get_available_featured() > 0): ?>
                                                                    <a class="btn btn-primary" href="<?php echo site_url('fproperties/make_featured/' . $lang_code . '/' . $estate->id . '/'); ?>">
                                                                        <?php echo '<i class="icon-circle-arrow-up"></i> ' . lang_check('Make featured'); ?>
                                                                    </a>
                                                                <?php elseif ($settings_featured_price > 0 && config_db_item('payments_enabled') == 1): ?>                        
                                                                    <div class="btn-group">
                                                                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                                                            <?php echo '<i class="icon-shopping-cart"></i> ' . lang_check('Pay for featured'); ?>
                                                                            <span class="caret"></span>
                                                                        </a>
                                                                        <ul class="dropdown-menu">
                                                                            <?php if (!_empty(config_db_item('paypal_email'))): ?>
                                                                                <li><a href="<?php echo site_url('frontend/do_purchase_featured/' . $lang_code . '/' . $estate->id . '/' . $settings_featured_price); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Pay for featured') . ' ' . lang_check('with PayPal'); ?></a></li>
                                                                            <?php endif; ?>

                                                                            <?php if (file_exists(APPPATH . 'controllers/paymentconsole.php') && !_empty(config_db_item('authorize_api_login_id'))): ?>
                                                                                <li><a href="<?php echo site_url('paymentconsole/authorize_payment/' . $lang_code . '/' . $settings_featured_price . '/' . $settings_default_currency . '/' . $estate->id . '/FEA'); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Pay for featured') . ' ' . lang_check('with CreditCard'); ?></a></li>
                                                                            <?php endif; ?>

                                                                            <?php if (!empty($settings_withdrawal_details) && file_exists(APPPATH . 'controllers/paymentconsole.php')): ?>
                                                                                <li><a href="<?php echo site_url('paymentconsole/invoice_payment/' . $lang_code . '/' . $settings_featured_price . '/' . $settings_default_currency . '/' . $estate->id . '/FEA'); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Buy/Extend') . ' ' . lang_check('with bank payment'); ?></a></li>
                                                                            <?php endif; ?>
                                                                        </ul>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endif; ?>

                                                        </td>
                                                        <td><?php echo anchor('frontend/editproperty/' . $lang_code . '/' . $estate->id, '<i class="icon-edit"></i> ' . lang('Edit'), array('class' => 'btn btn-info')) ?></td>
                                                        <td>
                                                            <?php echo anchor('property/' . $estate->id . '/' . $lang_code . '?preview=true', '<i class="icon-search icon-white"></i> ', array('class' => 'btn btn-success', 'target' => '_blank')) ?>
                                                            <?php if(config_db_item('events_qr_confirmation') === TRUE): ?>
                                                                <a href="<?php echo site_url('fproperties/events_qr/'.$lang_code.'/'.$estate->id.'/'); ?>" class="btn btn-info" target="_blank"><i class="icon-qrcode"></i> </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo anchor('frontend/deleteproperty/' . $lang_code . '/' . $estate->id, '<i class="icon-remove"></i> ' . lang('Delete'), array('onclick' => 'return confirm(\'' . lang_check('Are you sure?') . '\')', 'class' => 'btn btn-danger')) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="20"><?php echo lang_check('You can add your first property'); ?></td>
                                                </tr>
                                            <?php endif; ?>           
                                        </tbody>
                                    </table>
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

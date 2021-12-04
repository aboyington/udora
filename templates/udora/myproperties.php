<!DOCTYPE html>
<html>
<head>
    <?php _widget('head'); ?>
</head>
<body class="dashboard-body">
<?php _widget('header_menu'); ?>
<!-- Dashboard -->
<div class="container dashboard-layout">
    <div class="raw">
        <div class="col-xs-12">
            <div class="col-md-3 hidden-xs hidden-sm pad0">
                <?php _widget('custom_login_profile'); ?>
                <?php _widget('custom_loginusermenu'); ?>
            </div>
            <div class="col-xs-12 col-md-9 p-a-tomd-0">
                <div class="panel panel-default clearfix">
                    <!--                             <div class="panel-heading">DASHBOARD</div> -->
                    <ul class="nav nav-tabs dashboard__tabs">
                        <li class="active"><a data-toggle="tab" href="#activities" aria-expanded="true">Profile</a>
                        </li>
                        <!--
                        <li class=""><a data-toggle="tab" href="#friends" aria-expanded="false">Friends</a></li>
                        <li class=""><a data-toggle="tab" href="#invite" aria-expanded="false">Invite</a></li>
                        -->
                    </ul>
                    <div class="tab-content pt-2 clearfix">
                        <div id="activities" class="tab-pane fade active in pt-0">

                            <!--     Points and Levels    -->
                            <div class="col-xs-12 mb-4">
                                <div class="activities_user_info d-flex justify-content-between align-items-top">
                                    <div class="activities_user_name">
                                        <h4><?php echo $this->session->userdata('name_surname');?></h4>
                                        <p>533 000 4337</p>
                                        <p>joined in May, 2012</p>                                        
                                    </div>

                                    <?php if($this->session->userdata('profile_image') != '' && file_exists(FCPATH.$this->session->userdata('profile_image'))):?>
                                    <div  class="activities_user_foto" style="background-image: url('<?php echo base_url($this->session->userdata('profile_image'));?>');"></div>
                                    <?php else:?>
                                    <div  class="activities_user_foto" style="background-image: url('assets/img/user-agent.png');"></div>
                                    <?php endif;?>                                        
                                                                        
                                </div>
                                <div class="panel panel-default panel-no-border panel-score">
                                    <div class="panel-heading">Points &amp; Levels</div>
                                    <div class="panel_progress_score">
                                        <!-- if the left property more than 60% add class  ->  flex-row-reverse  -->
                                        <div class="panel_progress_score_item d-inline-flex justify-content-start align-items-center" style="left: 40%;">
                                            <!--<i class="material-icons">location_on</i>-->
                                            <img src="assets/img/marker_score.png"  class="marker_score" alt="marker_score">
                                            <span class="mb-0 text-center">Your points - <span class="weight-500">7203</span></span>
                                        </div>
                                    </div>
                                    <div class="panel_progress_body">
                                        <div class="panel_progress_body-items d-flex justify-content-between">
                                            <span class="panel_body-item text-center item_active">Novice</span>
                                            <span class="panel_body-item text-center item_active">Explorer</span>
                                            <span class="panel_body-item text-center">Celebrity</span>
                                            <span class="panel_body-item text-center">Legend</span>
                                            <span class="panel_body-item text-center">Elite</span>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--   //  Points and Levels End   -->


                            <!--     Activities    -->
                            <div class="col-xs-12">
                                <div class="panel panel-default panel-no-border panel-actives">
                                    <div class="panel-heading">Activities</div>
                                    <div id="activities_event" class="tab-pane fade in active / pt-3 pb-5">
                                        <div class="d-flex justify-content-between align-items-top flex-wrap">

                                            <a class="col-sm-5 col-xs-12 activities_event-link d-flex justify-content-between" href="<?php echo site_url('frontend/myevents/' . $lang_code . '#content'); ?>">
                                                <span class="activities_event-counter d-flex justify-content-center align-items-center"><?php echo count($estates); ?></span>
                                                <span class="activities_event-title"><?php echo lang_check('My events'); ?></span>
                                            </a>

                                            <a class="col-sm-5 col-xs-12 activities_event-link d-flex justify-content-between" href="<?php echo site_url('ffavorites/myfavorites/' . $lang_code . '#content'); ?>">
                                            <?php
                                                $CI = &get_instance();
                                                $CI->load->model('favorites_m');
                                                $research = $CI->favorites_m->get_by(array('user_id' => $this->session->userdata('id')));
                                            ?>
                                                <span class="activities_event-counter d-flex justify-content-center align-items-center"><?php echo count($research); ?></span>
                                                <span class="activities_event-title"><?php echo lang_check('Favorites'); ?></span>
                                            </a>

                                            <a class="col-sm-5 col-xs-12 activities_event-link d-flex justify-content-between" href="<?php echo site_url('frontend/myattended/' . $lang_code . '#content'); ?>">
                                                <?php
                                                    $CI = &get_instance();
                                                    $CI->load->model('userattend_m');
                                                    $attended = $CI->userattend_m->get_by(array('user_id' => $this->session->userdata('id')));
                                                ?>
                                                <span class="activities_event-counter d-flex justify-content-center align-items-center"><?php echo count($attended); ?></span>
                                                <span class="activities_event-title"><?php echo lang_check('Attended'); ?></span>
                                            </a>

                                            <a class="col-sm-5 col-xs-12 activities_event-link d-flex justify-content-between" href="javascript:;">
                                                <?php
                                                    $CI = &get_instance();
                                                    $CI->load->model('reviews_m');
                                                    $reviews = $CI->reviews_m->get_joined(array('user_id' => $this->session->userdata('id')));
                                                ?>
                                                <span class="activities_event-counter d-flex justify-content-center align-items-center"><?php echo count($reviews); ?></span>
                                                <span class="activities_event-title"><?php echo lang_check('Feedback'); ?></span>
                                            </a>

                                            <a class="col-sm-5 col-xs-12 activities_event-link d-flex justify-content-between" href="javascript:;">
                                                <span class="activities_event-counter d-flex justify-content-center align-items-center"><?php echo count($estates); ?></span>
                                                <span class="activities_event-title"><?php echo lang_check('Surveys'); ?></span>
                                            </a>

                                            <a class="col-sm-5 col-xs-12 activities_event-link d-flex justify-content-between" href="javascript:;">
                                                <span class="activities_event-counter d-flex justify-content-center align-items-center"><?php echo count($estates); ?></span>
                                                <span class="activities_event-title"><?php echo lang_check('Rewards'); ?></span>
                                            </a>
                                            
                                        </div>
                            
                                    </div>
                                </div>
                            </div>
                            <!--   //  Activities  End  -->

                        </div>
                        <div id="friends" class="tab-pane fade friends-wrap pt-0">
                            <div class="friend__item">
                                <div class="col-xs-3 col-sm-2 friend__item__img">
                                    <img src="assets/img/dashboard/jwalker.jpg" alt="">
                                    <!--                                             <span>
                                                                                    <button class="btn">Follow</button>
                                                                                </span> -->
                                </div>
                                <div class="col-xs-8 col-sm-5 col-md-4 friend__item__info">
                                    <a href="#" class="friend__item__info__title">John Walker</a>
                                    <ul class="list-inline friend__item__info__icons">
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/just-getting-started.png"
                                                             alt="Just getting started">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/picking-up-steam.png"
                                                             alt="Picking up steam">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/challenger.png"
                                                             alt="Challenger">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/challenge-accepted.png"
                                                             alt="Challenge accepted">
                                                    </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                                    <ul class="list-unstyled">
                                        <li>
                                            <span>Points: 350</span>
                                        </li>
                                        <li>
                                            <span>Member Since: Feb. 2018</span>
                                        </li>
                                        <li>
                                            <span>Member Status: Newbie</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="friend__item">
                                <div class="col-xs-3 col-sm-2 friend__item__img">
                                    <img src="assets/img/dashboard/mlee.jpg" alt="">
                                    <!--                                             <span>
                                                                                    <button class="btn">Follow</button>
                                                                                </span> -->
                                </div>
                                <div class="col-xs-8 col-sm-5 col-md-4 friend__item__info">
                                    <a href="#" class="friend__item__info__title">Michael Young</a>
                                    <ul class="list-inline friend__item__info__icons">
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/just-getting-started.png"
                                                             alt="Just getting started">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/picking-up-steam.png"
                                                             alt="Picking up steam">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/challenge-accepted.png"
                                                             alt="Challenge accepted">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/perseverance.png"
                                                             alt="Perseverance">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/natural.png"
                                                             alt="Natural">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/mastery.png"
                                                             alt="Mastery">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/mastery2.png"
                                                             alt="Mastery level 2">
                                                    </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                                    <ul class="list-unstyled">
                                        <li>
                                            <span>Points: 10500</span>
                                        </li>
                                        <li>
                                            <span>Member Since: Sept. 2016</span>
                                        </li>
                                        <li>
                                            <span>Member Status: Butterfly</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="friend__item">
                                <div class="col-xs-3 col-sm-2 friend__item__img">
                                    <img src="assets/img/dashboard/ftworld.jpg" alt="">
                                    <!--                                             <span>
                                                                                    <button class="btn">Follow</button>
                                                                                </span> -->
                                </div>
                                <div class="col-xs-8 col-sm-5 col-md-4 friend__item__info">
                                    <a href="#" class="friend__item__info__title">FTW World</a>
                                    <ul class="list-inline friend__item__info__icons">
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/guru.png" alt="Guru">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/incredible-inspiration.png"
                                                             alt="Incredible inspiration">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/power-hour.png"
                                                             alt="Power hour">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/sensei.png" alt="Sensei">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/going-transonic.png"
                                                             alt="Going transonic">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/going-supersonic.png"
                                                             alt="Going supersonic">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/ludicrous-streak.png"
                                                             alt="Ludicrous streak">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/atomic-clockwork.png"
                                                             alt="Atomic">
                                                    </span>
                                        </li>
                                        <li>
                                                    <span class="icon">
                                                        <img src="assets/img/dashboard/badges/1000-kelvin.png"
                                                             alt="1000 kelvin">
                                                    </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-offset-1">
                                    <ul class="list-unstyled">
                                        <li>
                                            <span>Points: 65200</span>
                                        </li>
                                        <li>
                                            <span>Member Since: Apr. 2015</span>
                                        </li>
                                        <li>
                                            <span>Member Status: Legend</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div id="invite" class="tab-pane fade">
                            <div class="container">
                                <div class="row pt-3">
                                    <div class="col-sm-7 col-md-6 mx-auto text-center float-none">
                                        <div class="row">
                                            <div class="col-xs-10 col-sm-12 mx-auto float-none">
                                                <h5 class="title-1 mb-1">Earn points when a friend you invited joins
                                                    Udora.</h5>
                                                <p class="mb-4">Or add a User Code to make new connections.</p>

                                                <div class="promocode mb-5">
                                                    <span class="promocode__title">Your User Code</span>
                                                    <span class="promocode__code">533 000 4703</span>
                                                </div>

                                                <!--                                                         <h5 class="title-1 mb-1">Earn points when a new friend you invited joins the app.</h5> -->
                                                <p class="mb-2">If your friend is already on Udora,
                                                    just enter their User Code below:</p>
                                            </div>
                                        </div>
                                        <input type="text" placeholder="Enter a friends User Code:"
                                               class="form-control style-1 mb-2">
                                        <button class="btn accent-button w-100 weight-400">Invite</button>
                                    </div>
                                </div>
                            </div>
                            <h5></h5>
                        </div>

                    </div>
                </div>
                <!--                         <?php if (file_exists(APPPATH . 'controllers/admin/packages.php')): ?>
                            <div class="recent-activity mobile-pad0 marg20">
                                <div class="panel panel-default">
                                    <div class="panel-heading">{lang_Mypackage}</div>
                                    <div class="panel-body">
                                        <div class="row-fluid">
                                            <div class="span12  panel panel-default panel-sidebar-1">
                                                <div class="property_content panel-body">
                                                    <div class="widget-content">
                                                        <?php if ($this->session->flashdata('error_package')): ?>
                                                            <p class="alert alert-error"><?php echo $this->session->flashdata('error_package') ?></p>
                                                        <?php endif; ?>
                                                        <table class="table table-striped footable table-packeges">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th data-type="html"><?php echo lang_check('Package name'); ?></th>
                                                                    <th data-type="html"><?php echo lang_check('Price'); ?></th>
                                                                    <th data-breakpoints="xs" data-type="html"><?php echo lang_check('Free property activation'); ?></th>
                                                                    <th data-breakpoints="xs sm md"  data-type="html"><?php echo lang_check('Days limit'); ?></th>
                                                                    <th data-breakpoints="xs sm md"  data-type="html"><?php echo lang_check('Listings limit'); ?></th>
                                                                    <th data-breakpoints="xs sm md"  data-type="html"><?php echo lang_check('Free featured limit'); ?></th>
                                                                    <th class="control" data-breakpoints="xs"  style="width: 120px;" data-type="html"><?php echo lang('Buy/Extend'); ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                    if (count($packages)): foreach ($packages as $package):
                        if (!empty($user['package_id']) &&
                            $user['package_id'] != $package->id &&
                            strtotime($user['package_last_payment']) >= time() &&
                            $packages_days[$package->id] > 0 &&
                            $packages_price[$user['package_id']] > 0) {
                            continue;
                        } else if (!empty($package->user_type) && $package->user_type != 'USER' && $user['package_id'] != $package->id) {
                            continue;
                        }
                        ?>
                                                                        <tr>
                                                                            <td><?php echo $package->id; ?></td>
                                                                            <td>
                                                                        <?php echo $package->package_name; ?>
                                                                            <?php echo $package->show_private_listings == 1 ? '&nbsp;<i class="icon-eye-open"></i>' : '&nbsp;<i class="icon-eye-close"></i>'; ?>
                                                                                <?php if ($user['package_id'] == $package->id): ?>
                                                                                    &nbsp;<span class="label label-success"><?php echo lang_check('Activated'); ?></span>
                                                                                <?php else: ?>
                                                                                    &nbsp;<span class="label label-important"><?php echo lang_check('Not activated'); ?></span>
                                                                                <?php endif; ?>

                                                                                <?php if ($package->package_price > 0 && $user['package_id'] == $package->id && strtotime($user['package_last_payment']) < time() && $packages_days[$package->id] > 0): ?>
                                                                                    &nbsp;<span class="label label-warning"><?php echo lang_check('Expired'); ?></span>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $package->package_price . ' ' . $package->currency_code; ?>
                                                                            </td>
                                                                            <td><?php echo $package->auto_activation ? '<i class="icon-ok"></i>' : ''; ?></td>
                                                                            <td>
                                                                                <?php
                        echo $package->package_days;

                        if ($user['package_id'] == $package->id && $package->package_price > 0 &&
                            strtotime($user['package_last_payment']) >= time() && $packages_days[$package->id] > 0) {
                            echo ', ' . $user['package_last_payment'];
                        }
                        ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $package->num_listing_limit ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php echo $package->num_featured_limit ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php if ($package->package_price > 0 && config_db_item('payments_enabled') == 1): ?>                     
                                                                                    <div class="btn-group">
                                                                                        <a class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
                                                                                    <?php echo '<i class="icon-white icon-shopping-cart"></i> ' . lang('Buy/Extend'); ?>
                                                                                            <span class="caret"></span>
                                                                                        </a>
                                                                                        <ul class="dropdown-menu">
                                                                                    <?php if (!_empty(config_db_item('paypal_email'))): ?>
                                                                                                <li><a href="<?php echo site_url('frontend/do_purchase_package/' . $lang_code . '/' . $package->id . '/' . $package->package_price); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Buy/Extend') . ' ' . lang_check('with PayPal'); ?></a></li>
                                                                                            <?php endif; ?>
                                                                                            <?php if (file_exists(APPPATH . 'controllers/paymentconsole.php') && !_empty(config_db_item('authorize_api_login_id'))): ?>
                                                                                                <li><a href="<?php echo site_url('paymentconsole/authorize_payment/' . $lang_code . '/' . $package->package_price . '/' . $package->currency_code . '/' . $package->id . '/PAC'); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Buy/Extend') . ' ' . lang_check('with CreditCard'); ?></a></li>
                                                                                            <?php endif; ?>
                                                                                            <?php if (!empty($settings_withdrawal_details) && file_exists(APPPATH . 'controllers/paymentconsole.php') || TRUE): ?>
                                                                                                <li><a href="<?php echo site_url('paymentconsole/invoice_payment/' . $lang_code . '/' . $package->package_price . '/' . $package->currency_code . '/' . $package->id . '/PAC'); ?>"><?php echo '<i class="icon-shopping-cart"></i> ' . lang('Buy/Extend') . ' ' . lang_check('with bank payment'); ?></a></li>
                                                                                            <?php endif; ?>
                                                                                        </ul>
                                                                                    </div>
                                                                                <?php endif; ?>                               
                                                                            </td>
                                                                        </tr>
                                                                            <?php endforeach; ?>
                                                                        <?php else: ?>
                                                                    <tr>
                                                                        <td colspan="20"><?php echo lang_check('Not available'); ?></td>
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
                        <?php endif; ?> -->
            </div>
             <div class="col-xs-12 d-block d-md-none pad0">
                <div class="bottom_login_usermenu">
                    <?php _widget('custom_loginusermenu'); ?>
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

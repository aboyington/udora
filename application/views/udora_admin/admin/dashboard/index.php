<!-- top tiles -->
<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-ticket"></i> <?php echo lang_check('Total Events');?></span>
        <div class="count"><?php _che($total_events);?></div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> <?php echo lang_check('Total Users');?></span>
        <div class="count green"><?php _che($total_users);?></div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>4% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> <?php echo lang_check('Total Males');?></span>
        <div class="count"><?php _che($total_users_males);?></div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i><?php echo lang_check('Total Females');?> </span>
        <div class="count"><?php _che($total_users_females);?></div>
        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Cities</span>
        <div class="count">10</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-user"></i> Total Countries</span>
        <div class="count">2</div>
        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
    </div>
</div>
<!-- /top tiles -->

<!-- Add page / events button -->
<div class="x_panel">
    <div class="x_title">
        <h2><?php echo lang_check('Quick Add');?></h2>
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
        <?php echo anchor('admin/estate/edit', lang('Add an Event'), 'class="btn btn-primary"')?>
        <?php echo anchor('admin/user/edit', lang('Add an Agent'), 'class="btn btn-primary-blue"')?>
        <?php echo anchor('admin/user/edit', lang('Add a User'), 'class="btn btn-success"')?>
    </div>
</div>
<!-- /Add page / events button -->


<!-- Vistors location -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Events by country</h2>
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
                <div class="dashboard-widget-content">
                    <div class="col-md-4 hidden-small">
                        <h4>5,315 events from 60 countries</h4>

                        <table class="countries_list">
                            <tbody>
                                <tr>
                                    <td>United States</td>
                                    <td class="fs15 fw700 text-right">656</td>
                                </tr>
                                <tr>
                                    <td>France</td>
                                    <td class="fs15 fw700 text-right">455</td>
                                </tr>
                                <tr>
                                    <td>Germany</td>
                                    <td class="fs15 fw700 text-right">354</td>
                                </tr>
                                <tr>
                                    <td>Spain</td>
                                    <td class="fs15 fw700 text-right">223</td>
                                </tr>
                                <tr>
                                    <td>Britain</td>
                                    <td class="fs15 fw700 text-right">110</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height:230px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //Vistors location -->

<!-- Table -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?php echo lang_check('Last added Event');?></h2>
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
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo lang_check('Address');?></th>
                            <!-- Dynamic generated -->
                            <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                            <th data-hide="phone,tablet"><?php echo $row->option?></th>
                            <?php endforeach;?>
                            <!-- End dynamic generated -->
                            <th><?php echo lang('Edit');?></th>
                            <?php if(check_acl('estate/delete')):?><th><?php echo lang('Delete');?></th><?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($estates)): foreach($estates as $estate):?>
                        <tr>
                            <?php if($estate->is_activated == 0):?>
                            <td><span class="label label-danger"><?php echo $estate->id?></span></td>
                            <?php else:?>
                            <td><?php echo $estate->id?></td>
                            <?php endif;?>
                            <td><?php echo anchor('admin/estate/edit/'.$estate->id, _ch($estate->address) )?>
                            <!-- Dynamic generated -->
                            <?php foreach($this->option_m->get_visible($content_language_id) as $row):?>
                            <td>
                            <?php
                                echo $this->estate_m->get_field_from_listing($estate, $row->option_id);
                            ?>
                            </td>
                            <?php endforeach;?>
                            <!-- End dynamic generated -->
                            <td><a href="<?php echo site_url('admin/estate/edit/'.$estate->id);?>"><i class="fa fa-edit"></i></a></td>
                            <?php if(check_acl('estate/delete')):?>
                            <td><a href="<?php echo site_url('admin/estate/delete/'.$estate->id);?>"><i class="fa fa-close"></i></a></td>
                            <?php endif;?>
                        </tr>
                    <?php endforeach;?>
                    <?php else:?> 
                        <tr>
                            <td colspan="5"><?php echo lang('We could not find any');?></td>
                        </tr>
                     <?php endif;?>    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- / Table -->					


<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>App Versions</h2>
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
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <h4>App Usage across versions</h4>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>0.1.5.2</span>
                    </div>
                    <div class="w_center w_55">
                        <div class="progress">
                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%;">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="w_right w_20">
                        <span>123k</span>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>0.1.5.3</span>
                    </div>
                    <div class="w_center w_55">
                        <div class="progress">
                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="w_right w_20">
                        <span>53k</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>0.1.5.4</span>
                    </div>
                    <div class="w_center w_55">
                        <div class="progress">
                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="w_right w_20">
                        <span>23k</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>0.1.5.5</span>
                    </div>
                    <div class="w_center w_55">
                        <div class="progress">
                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="w_right w_20">
                        <span>3k</span>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="widget_summary">
                    <div class="w_left w_25">
                        <span>0.1.5.6</span>
                    </div>
                    <div class="w_center w_55">
                        <div class="progress">
                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </div>
                    <div class="w_right w_20">
                        <span>1k</span>
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320 overflow_hidden">
            <div class="x_title">
                <h2>Device Usage</h2>
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
                <table class="" style="width:100%">
                    <tr>
                        <th style="width:37%;">
                            <p>Top 5</p>
                        </th>
                        <th>
                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                <p class="">Device</p>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                <p class="">Progress</p>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                        </td>
                        <td>
                            <table class="tile_info">
                                <tr>
                                    <td>
                                        <p><i class="fa fa-square blue"></i>IOS </p>
                                    </td>
                                    <td>30%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><i class="fa fa-square green"></i>Android </p>
                                    </td>
                                    <td>10%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><i class="fa fa-square purple"></i>Blackberry </p>
                                    </td>
                                    <td>20%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><i class="fa fa-square aero"></i>Symbian </p>
                                    </td>
                                    <td>15%</td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><i class="fa fa-square red"></i>Others </p>
                                    </td>
                                    <td>30%</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel tile fixed_height_320">
            <div class="x_title">
                <h2>Quick Settings</h2>
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
                <div class="dashboard-widget-content">
                    <ul class="quick-list">
                        <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>
                        </li>
                        <li><i class="fa fa-bars"></i><a href="#">Subscription</a>
                        </li>
                        <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                        <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                        </li>
                        <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>
                        <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>
                        </li>
                        <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>
                        </li>
                    </ul>

                    <div class="sidebar-widget">
                        <h4>Profile Completion</h4>
                        <canvas width="150" height="80" id="chart_gauge_01" class="" style="width: 160px; height: 100px;"></canvas>
                        <div class="goal-wrapper">
                            <span id="gauge-text" class="gauge-value pull-left">0</span>
                            <span class="gauge-value pull-left">%</span>
                            <span id="goal-text" class="goal-value pull-right">100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <!-- <div class="col-md-4 col-sm-4 col-xs-12"> -->
        <div class="x_panel">
            <div class="x_title">
                <h2>Recent Activities <small>Sessions</small></h2>
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
                <div class="dashboard-widget-content">

                    <ul class="list-unstyled timeline widget">
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title">
                                        <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                    </h2>
                                    <div class="byline">
                                        <span>13 hours ago</span> by <a>Jane Smith</a>
                                    </div>
                                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title">
                                        <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                    </h2>
                                    <div class="byline">
                                        <span>13 hours ago</span> by <a>Jane Smith</a>
                                    </div>
                                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title">
                                        <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                    </h2>
                                    <div class="byline">
                                        <span>13 hours ago</span> by <a>Jane Smith</a>
                                    </div>
                                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="block">
                                <div class="block_content">
                                    <h2 class="title">
                                        <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                    </h2>
                                    <div class="byline">
                                        <span>13 hours ago</span> by <a>Jane Smith</a>
                                    </div>
                                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
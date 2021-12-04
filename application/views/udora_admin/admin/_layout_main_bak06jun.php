<?php $this->load->view('admin/components/page_head_main') ?>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?php echo site_url('admin/dashboard')?>" class="site_title">
                        <img src="<?php echo base_url('adminudora-assets/images/udora-admin-logo.png') ?>" alt="Udora logo" class="site_logo">
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <?php if ($this->session->userdata('profile_image') != ''): ?>
                                <img class="profile-pic animated" src="<?php echo base_url($this->session->userdata('profile_image')); ?>" alt="">
                            <?php else: ?>
                                <img class="profile-pic animated" src="<?php echo base_url('adminudora-assets/img/admin.png'); ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="profile_info">
                            <span><?php echo lang_check('Welcome');?>,</span>
                            <h2><?php echo $this->session->userdata('name_surname')?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li class="<?php echo (strpos($this->uri->uri_string(),'dashboard')!==FALSE || $this->uri->uri_string() == 'admin')?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/dashboard')?>"><i class="fa fa-home"></i>Dashboard</a>
                                </li>
                                <?php if(config_item('admin_beginner_enabled') === TRUE):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'user/edit/'.$this->session->userdata('id'))!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/user/edit/'.$this->session->userdata('id'))?>"><i class="fa fa-user"></i><?php echo lang_check('Profile');?></a>
                                </li>
                                <?php endif;?>
                                <?php if(check_acl('page') && config_db_item('frontend_disabled') === FALSE):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'page')!==FALSE)?' current':'';?>">
                                    <a href="<?php echo site_url('admin/page')?>"><i class="fa fa-sitemap"></i> <?php echo lang_check('Pages & menu');?></a>
                                </li>
                                <?php endif;?>
                                
                                <!-- Menu with sub menu -->
                                <li class="<?php echo (strpos($this->uri->uri_string(),'estate')!==FALSE || strpos($this->uri->uri_string(),'reports')==TRUE || strpos($this->uri->uri_string(),'treefield')==TRUE)?' active':'';?>">
                                  <a><i class="fa fa-location-arrow"></i><?php echo lang_check('Locations & Events');?><span class="fa fa-chevron-down"></span></a>

                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/estate')?>"><?php echo lang_check('Manage');?></a></li>
                                    <?php if(check_acl('estate/options')):?>
                                    <li><a href="<?php echo site_url('admin/estate/options')?>"><?php echo lang_check('Fields');?></a></li>
                                    <li><a href="<?php echo site_url('admin/estate/dependent_fields')?>"><?php echo lang_check('Dependent fields');?></a></li>
                                    <?php endif;?>
                                    <?php if(check_acl('estate/forms') && config_item('search_forms_editor_enabled') == TRUE):?>
                                    <li><a href="<?php echo site_url('admin/estate/forms')?>"><?php echo lang_check('Search forms');?></a></li>
                                    <?php endif;?>

                                    <?php
                                        if(file_exists(APPPATH.'controllers/admin/treefield.php') && $this->session->userdata('type') == 'ADMIN')
                                        {
                                            $CI =& get_instance();
                                            $CI->load->model('option_m');
                                            $option_treefield = $CI->option_m->get(64);
                                            if(!empty($option_treefield) && $option_treefield->type == 'TREE')
                                            {
                                    echo '<li><a href="'.site_url('admin/treefield/edit/64').'">'.lang_check('Treefield values').'</a></li>';        
                                            }

                                            $option_treefield = $CI->option_m->get(79);
                                            if(!empty($option_treefield) && $option_treefield->type == 'TREE')
                                            {
                                    echo '<li><a href="'.site_url('admin/treefield/edit/79').'">'.lang_check('Categories').'</a></li>';        
                                            }
                                        }

                                    ?>
                                    <?php if(config_item('admin_beginner_enabled') === TRUE):?>
                                    <?php
                                        if($this->session->userdata('type') == 'ADMIN')
                                        {
                                            $CI =& get_instance();
                                            $CI->load->model('option_m');
                                            $option_treefield = $CI->option_m->get(2);
                                            if(!empty($option_treefield))
                                            {
                                    echo '<li><a href="'.site_url('admin/estate/edit_option/2').'">'.lang_check('Type values').'</a></li>';        
                                            }
                                        }

                                    ?>

                                    <?php
                                        if($this->session->userdata('type') == 'ADMIN')
                                        {
                                            $CI =& get_instance();
                                            $CI->load->model('option_m');
                                            $option_treefield = $CI->option_m->get(4);
                                            if(!empty($option_treefield) && $option_treefield->type == 'DROPDOWN')
                                            {
                                    echo '<li><a href="'.site_url('admin/estate/edit_option/4').'">'.lang_check('Purpose values').'</a></li>';        
                                            }
                                        }

                                    ?>
                                    <?php endif;?>
                                    <?php if(config_item('report_property_enabled') == TRUE && $this->session->userdata('type') == 'ADMIN'):?>
                                    <li><a href="<?php echo site_url('admin/reports')?>"><?php echo lang_check('Reported');?></a></li>
                                    <?php endif;?>
                                    <?php if(config_item('status_enabled') === TRUE && 
                                             $this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE'):?>
                                    <li><a href="<?php echo site_url('admin/estate/contracted')?>"><?php echo lang_check('Contracted');?></a></li>
                                    <li><a href="<?php echo site_url('admin/estate/statuses')?>"><?php echo lang_check('Statuses');?></a></li>
                                    <?php endif;?>
                                    <?php if(config_item('removed_reports_enabled') === TRUE && 
                                             ( $this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE' ||
                                               $this->session->userdata('type') == 'ADMIN' )
                                             ):?>
                                    <li><a href="<?php echo site_url('admin/estate/removed')?>"><?php echo lang_check('Removed');?></a></li>
                                    <?php endif;?>
                                  </ul>
                                </li>
                                
                                <?php if(config_item('admin_beginner_enabled') === TRUE):?>
                                    <?php if(check_acl('user')):?>
                                    <li class="<?php echo (strpos($this->uri->uri_string(),'user')!==FALSE && strpos($this->uri->uri_string(),'user/edit/'.$this->session->userdata('id'))===FALSE)?' current-page':'';?>"><a href="<?php echo site_url('admin/user')?>"><i class="fa fa-users"></i> <?php echo lang_check('Agents & Users');?></a></li>
                                    <?php endif;?>


                                    <?php if(check_acl('enquire') && config_db_item('frontend_disabled') === FALSE):?>
                                    <li class="<?php echo (strpos($this->uri->uri_string(),'enquire')!==FALSE)?' current-page':'';?>"><a href="<?php echo site_url('admin/enquire')?>"><i class="fa fa-envelope-o"></i><?php echo lang_check('Enquires');?></a></li>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php if(check_acl('slideshow') && config_db_item('frontend_disabled') === FALSE):?>
                                    <li class="<?php echo (strpos($this->uri->uri_string(),'slideshow')!==FALSE)?' current-page':'';?>"><a href="<?php echo site_url('admin/slideshow')?>"><i class="fa fa-image"></i><?php echo lang_check('Slideshow')?></a></li>
                                    
                                    <li class="nlightblue<?php echo (strpos($this->uri->uri_string(),'statistics')!==FALSE)?' active':'';?>"><a><i class="fa fa-bar-chart-o"></i><?php echo lang_check('Analytics');?><span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="https://www.google.com/analytics/web">Google Analytics</a></li>
                                            <li><a href="<?php echo site_url('admin/analitics/event_stats')?>">Event Stats</a></li>
                                            <li><a href="<?php echo site_url('admin/analitics/event_stats2')?>">Event Stats2</a></li>
                                        </ul>
                                    </li>
                                <?php endif;?>
                                    
                                <?php if(check_acl('backup')):?>
                                    <li class="norange<?php echo (strpos($this->uri->uri_string(),'backup')!==FALSE)?' current-page':'';?>"><a href="<?php echo site_url('admin/backup')?>"><i class="fa fa-hdd-o"></i><?php echo lang_check('Backup')?></a></li>
                                <?php endif;?>
                                    
                                <?php if(file_exists(APPPATH.'controllers/admin/news.php') && check_acl('news')):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'news')!==FALSE)?' active':'';?>">
                                    <a><i class="fa fa-newspaper-o"></i><?php echo lang_check('News/Blog');?><span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('admin/news')?>"><?php echo lang_check('Manage');?></a></li>
                                        <li><a href="<?php echo site_url('admin/news/categories')?>"><?php echo lang_check('Categories');?></a></li>
                                    </ul>
                                </li>
                                <?php endif;?>
                                
                                <?php if(file_exists(APPPATH.'controllers/admin/packages.php') && check_acl('packages')):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'packages')!==FALSE)?' active':'';?>">
                                    <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-gift"></i> <?php echo lang_check('Packages');?>
                                        <!-- Icon for dropdown -->
                                       <span class="fa fa-chevron-down"></span>
                                    </a>
                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/packages')?>"><?php echo lang_check('Manage');?></a></li>
                                    <li><a href="<?php echo site_url('admin/packages/users')?>"><?php echo lang_check('Users');?></a></li>
                                    <?php if(config_db_item('enable_county_affiliate_roles') === TRUE): ?>
                                    <li><a href="<?php echo site_url('admin/packages/affilatepackage')?>"><?php echo lang_check('Affilate package');?></a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo site_url('admin/packages/payments')?>"><?php echo lang_check('Payments');?></a></li>
                                  </ul>
                                </li>
                                <?php elseif(file_exists(APPPATH.'controllers/admin/packages.php') && check_acl('packages/mypackage')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'packages')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/packages/mypackage')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-gift"></i> <?php echo lang_check('My package');?>
                                    </a>
                                </li>
                                <?php elseif(config_db_item('enable_county_affiliate_roles') === TRUE && 
                                         $this->session->userdata('type') == 'AGENT_COUNTY_AFFILIATE' && check_acl('packages/affilatepackage')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'packages')!==FALSE)?' ccurrent-page':'';?>">
                                    <a href="<?php echo site_url('admin/packages/affilatepackage'); ?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-gift"></i> <?php echo lang_check('Affilate package');?>
                                    </a>
                                </li>
                                <?php endif;?>
                                
                                <?php if(file_exists(APPPATH.'controllers/admin/reviews.php') && check_acl('reviews')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'reviews')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/reviews')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-tags"></i> <?php echo lang_check('Reviews');?>
                                    </a>
                                </li>
                                <?php endif;?>
                                            
                                <?php if(file_exists(APPPATH.'controllers/admin/favorites.php') && check_acl('favorites')): ?>
                                <li class="nblue<?php echo (strpos($this->uri->uri_string(),'favorites')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/favorites')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-star"></i> <?php echo lang_check('Favorites');?>
                                    </a>
                                </li>
                                <?php endif;?>
            
                                            
            
                                <?php if(check_acl('monetize') && config_db_item('frontend_disabled') === FALSE):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'monetize')!==FALSE)?' active':'';?>">
                                    <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-dollar"></i> <?php echo lang_check('Payments');?>
                                        <!-- Icon for dropdown -->
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/monetize/payments')?>"><?php echo lang_check('Activations');?></a></li>
                                    <li><a href="<?php echo site_url('admin/monetize/payments_featured')?>"><?php echo lang_check('Featured');?></a></li>
                                    <?php if(file_exists(APPPATH.'controllers/paymentconsole.php')): ?>
                                    <li><a href="<?php echo site_url('admin/monetize/invoices')?>"><?php echo lang_check('Invoices');?></a></li>
                                    <?php endif; ?>
                                  </ul>
                                </li>
                                <?php endif;?>
                                
                                <?php if(config_item('admin_beginner_enabled') === TRUE):?>
                                <?php if(check_acl('settings')):?>
                                    <li class="<?php echo (strpos($this->uri->uri_string(),'settings')!==FALSE)?' current open':'';?>">
                                      <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa fa-gears"></i> <?php echo lang_check('Settings');?> 
                                        <!-- Icon for dropdown -->
                                        <span class="fa fa-chevron-down"></span>
                                      </a>

                                      <ul class="nav child_menu">
                                        <li><a href="<?php echo site_url('admin/settings')?>"><?php echo lang_check('Company details');?></a></li>
                                        <li><a href="<?php echo site_url('admin/settings/language')?>"><?php echo lang_check('Languages');?></a></li>
                                        <li><a href="<?php echo site_url('admin/settings/template')?>"><?php echo lang_check('Template');?></a></li>
                                        <li><a href="<?php echo site_url('admin/settings/system')?>"><?php echo lang_check('System');?></a></li>
                                        <li><a href="<?php echo site_url('admin/settings/addons')?>"><?php echo lang_check('Addons');?></a></li>
                                        <?php if(config_db_item('currency_conversions_enabled') === TRUE): ?>
                                        <li><a href="<?php echo site_url('admin/settings/currency_conversions')?>"><?php echo lang_check('Currency Conversions');?></a></li>
                                        <?php endif; ?>
                                      </ul>
                                    </li>
                                <?php endif;?>
                                <?php endif;?>
                                    
                                    
                                <?php if(file_exists(APPPATH.'controllers/admin/ads.php') && check_acl('ads')):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'ads')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/ads')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-globe"></i> <?php echo lang_check('Ads');?>
                                    </a>
                                </li>
                                <?php endif;?>

                                <?php if(file_exists(APPPATH.'controllers/admin/showroom.php') && check_acl('showroom')):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'showroom')!==FALSE)?' activr':'';?>">
                                    <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-briefcase"></i> <?php echo lang_check('Showroom');?>
                                        <!-- Icon for dropdown -->
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/showroom')?>"><?php echo lang_check('Manage');?></a></li>
                                    <li><a href="<?php echo site_url('admin/showroom/categories')?>"><?php echo lang_check('Categories');?></a></li>
                                  </ul>
                                </li>
                                <?php endif;?>

                                <?php if(file_exists(APPPATH.'controllers/admin/expert.php') && check_acl('expert')):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'expert')!==FALSE)?' active':'';?>">
                                    <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-comment"></i> <?php echo lang_check('Q&A');?>
                                        <!-- Icon for dropdown -->
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/expert')?>"><?php echo lang_check('Manage');?></a></li>
                                    <li><a href="<?php echo site_url('admin/expert/categories')?>"><?php echo lang_check('Categories');?></a></li>
                                  </ul>
                                </li>
                                <?php endif;?>

                                <?php if(file_exists(APPPATH.'controllers/admin/booking.php') && check_acl('booking')):?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'booking')!==FALSE)?' active':'';?>">
                                    <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-shopping-cart"></i> <?php echo lang_check('Booking');?>
                                        <!-- Icon for dropdown -->
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/booking')?>"><?php echo lang_check('Reservations');?></a></li>
                                    <li><a href="<?php echo site_url('admin/booking/rates')?>"><?php echo lang_check('Rates');?></a></li>
                                    <li><a href="<?php echo site_url('admin/booking/payments')?>"><?php echo lang_check('Payments');?></a></li>
                                    <?php if($this->session->userdata('type') == 'ADMIN'): ?>
                                    <li><a href="<?php echo site_url('admin/booking/withdrawals')?>"><?php echo lang_check('Withdrawals');?></a></li>
                                    <?php endif; ?>
                                  </ul>
                                </li>
                                <?php endif;?>

                                <?php if(config_item('enable_table_calendar') === TRUE && check_acl('tcalendar')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'tcalendar')!==FALSE)?' active':'';?>">
                                    <a>
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-calendar"></i> <?php echo lang_check('TCalendar');?>
                                        <!-- Icon for dropdown -->
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                  <ul class="nav child_menu">
                                    <li><a href="<?php echo site_url('admin/tcalendar/available')?>"><?php echo lang_check('Available');?></a></li>
                                  </ul>
                                </li>
                                <?php endif; ?>


                                <?php if(file_exists(APPPATH.'controllers/admin/savesearch.php') && check_acl('savesearch')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'savesearch')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/savesearch')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-filter"></i> <?php echo lang_check('Research');?>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php if(config_item('map_report_enabled') === TRUE && check_acl('mapreport')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'mapreport')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/mapreport')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-bar-chart"></i> <?php echo lang_check('Map report');?>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php if(config_item('enable_benchmark_tools') === TRUE && check_acl('benchmarktool')): ?>
                                <li class="<?php echo (strpos($this->uri->uri_string(),'benchmarktool')!==FALSE)?' current-page':'';?>">
                                    <a href="<?php echo site_url('admin/benchmarktool')?>">
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-fire"></i> <?php echo lang_check('Benchmark tools');?>
                                    </a>
                                </li>
                                <?php endif; ?>    
                                <li class="">
                                    <a href="https://udora.io/support/login/" target="_blank">
                                        <!-- Menu name with icon -->
                                        <i class="fa icon-fire"></i> <?php echo lang_check('Support Center');?>
                                    </a>
                                </li>
                                    
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->

                    <!-- menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo site_url('admin/user/logout') ?>">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php if ($this->session->userdata('profile_image') != ''): ?>
                                        <img class="profile-pic animated" src="<?php echo base_url($this->session->userdata('profile_image')); ?>" alt="">
                                    <?php else: ?>
                                        <img class="profile-pic animated" src="<?php echo base_url('adminudora-assets/img/admin.png'); ?>" alt="">
                                    <?php endif; ?>
                                    
                                    <?php echo $this->session->userdata('name_surname')?> <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="<?php echo site_url('admin/user/edit/' . $this->session->userdata('id')) ?>"><?php echo lang_check('Profile'); ?></a></li>
                                    <?php if (check_acl('settings')): ?>
                                    <li><a href="<?php echo site_url('admin/settings') ?>"><?php echo lang_check('Settings'); ?></a></li>
                                    <?php endif; ?>
                                    <li><a target="_blank" href="<?php echo site_url(''); ?>"><?php echo lang_check('Website link'); ?></a></li>
                                    <li><a href="<?php echo site_url('admin/user/logout') ?>"><i class="fa fa-sign-out pull-right"></i> <?php echo lang_check('Logout'); ?></a></li>
                                </ul>
                            </li>
                            <!-- alerts -->
                            <li role="presentation" class="dropdown">
                                <?php
                                /* $enquire_3 add image of profile */

                                /*
                                 * function for array_walk();
                                 * add in $enquire_3 profile image for user message
                                 * 
                                 * use array_walk($enquire_3, 'add_profile_image');
                                 */

                                function add_profile_image(&$item, $key) {
                                    $CI = & get_instance();
                                    if (empty($item->mail))
                                        return false;
                                    $user = $CI->user_m->get_counted('mail LIKE \'' . $item->mail . '\'', FALSE, 1, 'properties_count DESC, user_id');
                                    $profile_image = $CI->file_m->get_by(array('repository_id' => $user[0]->repository_id))[0];
                                    if (!empty($profile_image) and file_exists(FCPATH . '/files/' . $profile_image->filename)) {
                                        $profile_image = base_url('/files/' . $profile_image->filename);
                                    } else {
                                        $profile_image = base_url('adminudora-assets/img/admin.png');
                                    }
                                    $item->profile_image = $profile_image;
                                }

                                array_walk($enquire_3, 'add_profile_image');
                                /* end $enquire_3 add image of profile */
                                ?>
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green"><?php echo $this->enquire_m->total_unreaded();?></span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <?php foreach ($enquire_3 as $enquire): ?>
                                        <li>
                                            <a href="<?php echo site_url('admin/enquire/edit/' . $enquire->id); ?>">
                                                <span class="image"><img src="<?php echo $enquire->profile_image; ?>" alt="Profile Image" /></span>
                                                <span>
                                                    <span><?php echo $enquire->name_surname; ?></span>
                                                    <span class="time"><?php echo $enquire->date; ?></span>
                                                </span>
                                                <span class="message">
                                                    <?php echo word_limiter(strip_tags($enquire->message), 25); ?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>    

                                    <li>
                                        <div class="text-center">
                                            <a href="<?php echo site_url('admin/enquire') ?>">
                                                <strong><?php echo lang_check('View All'); ?></strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- // alerts -->
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
                <?php $this->load->view($subview) ?>
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    © Udora Technologies | Trademarks and brands are the property of their respective owners.
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
<?php $this->load->view('admin/components/page_tail_main') ?>
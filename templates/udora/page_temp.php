<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
<style>
    #codeigniter_profiler {
        display: none;
    }
</style>
</head>
<body class="no-padding footer-nav-black home home-page">
    <?php _widget('header_search');?>
    <?php
    $treefields = generate_treefields_list(79);

    $defaul_icons = array('la la-home','la la-hand-pointer-o','la la-unlock','la la-star-o');

    $defaul_images = array(
                            'assets/images/categories/1.jpg',
                            'assets/images/categories/2.jpg',
                            'assets/images/categories/3.jpg',
                            'assets/images/categories/4.jpg',
                            'assets/images/categories/5.jpg',
                            'assets/images/categories/6.jpg',
                            'assets/images/categories/7.jpg',
                            'assets/images/categories/8.jpg',
                            'assets/images/categories/9.jpg',
                            'assets/images/categories/10.jpg',
                            'assets/images/categories/11.jpg',
                        );
    ?>
    
    <div class="section sect-popular-categories">
        <div class="container">
            <div class="sect_title"><h2><?php echo lang_check('Popular categories');?></h2></div>
            <div class="row">
                <?php $i=0;  foreach ($treefields as $key=>$item): ?>
                <?php if ($i>=8) break; ?>
                 <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href='<?php _che($item['url']);?>' class="card-pop-category">
                        <div class="p_thumbnail"><img src="<?php _che($item['thumbnail_url'], $defaul_images[$key]);?>" alt="<?php _che($item['title']);?>" class="img-fluid"></div>
                        <div class="p_body">
                            <h3 class="p_title"><?php _che($item['title']);?></h3>
                        </div>
                    </a>
                </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
    </div>
    
        <?php
        $CI = &get_instance();
        $CI->load->model('estate_m');
        $CI->load->model('option_m');

        $last_n = 6;
        $top_n_estates = $this->estate_m->get_by(array('is_activated' => 1, /*'is_featured' => 1,*/ 'language_id'=>$lang_id), FALSE, $last_n, 'RAND()', NULL, array( 'v_search_option_location'=>'Toronto'));
        $options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);

        $top_estates_num = $last_n;
        $top_estates = array();
        $CI->generate_results_array($top_n_estates, $top_estates, $options_name); 

        ?>
        <?php if(sw_count($top_estates)):?>
        <div class="section sect-featured">
            <div class="container">
                <div class="sect_title"><h2><?php echo lang_check('Featured events in');?> (<a class="link-s" href='<?php echo site_url($lang_code . '/' . get_results_page_id() . '/?search={"v_search_option_location":"Canada, Toronto"}');?>'><?php echo lang_check('Toronto');?></a>)</h2></div>
                <div class="row row-flex">
                    <?php foreach($top_estates as $key=>$item): ?>
                        <?php
                        $date_start='';
                        if(isset($item['option_81']) && !empty($item['option_81'])){
                            $_strtotime = strtotime($item['option_81']);
                            $day = date('l',$_strtotime);
                            $day = strtolower($day);
                            $month = date('M',$_strtotime);
                            $month = strtolower($month);
                            $date_start =  lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '. date('d, g:i a', $_strtotime);
                        }
                        ?>
                        <div class="col-md-4 col-sm-6 col-xs-6">
                            <div class="featured__item <?php echo ($item['is_featured']==1) ? 'features':''; ?>">
                            <a href="<?php echo $item['url']; ?>" class="featured__item__img" alt="<?php _che($item['option_10']); ?>" style="background-image: url('<?php echo _simg($item['thumbnail_url'], '645x480', true); ?>')"></a>
                                <div class="featured__item__body">
                                <a href="<?php echo $item['url']; ?>" alt="<?php _che($item['option_10']); ?>" class="featured__item__title"><?php _che($item['option_10']); ?></a>
                                <?php if(!empty($date_start)):?>    
                                    <div class="featured__item__info">
                                    <span class="icon-fixed text-center mr-1"><i class="ion-android-time"></i></span>
                                    <span><?php echo $date_start;?></span>
                                    </div>
                                <?php endif;?>
                                <div class="featured__item__info mb-2">
                                    <span class="icon-fixed text-center mr-1"><i class="ion-ios-location"></i></span>
                                    <span><?php _che($item['address']); ?></span>
                                </div>
                                <p class="featured__item__description mb-2"><?php _che($item['option_chlimit_8']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                <div class="col-xs-12">
                    <div class="text-center"><a href="#" class="feat_more"><?php echo lang_check('Show all featured events');?></a></div>
                </div>
            </div><!--widget-featured-property end-->
        </div>
    </div>
    <?php endif;?>
    
            <?php
        $CI = &get_instance();
        $CI->load->model('estate_m');
        $CI->load->model('option_m');

        $last_n = 6;
        $top_n_estates = $this->estate_m->get_by(array('is_activated' => 1, /*'is_featured' => 1,*/ 'language_id'=>$lang_id), FALSE, $last_n, 'RAND()', NULL, array());
        $options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);

        $top_estates_num = $last_n;
        $top_estates = array();
        $CI->generate_results_array($top_n_estates, $top_estates, $options_name); 

        ?>
        <?php if(sw_count($top_estates)):?>
        <div class="section sect-featured sect-featured-w">
            <div class="container">
                <div class="sect_title"><h2><?php echo lang_check('Featured worldwide');?></h2></div>
            <div class="row row-flex">
            <?php foreach($top_estates as $key=>$item): ?>
                <?php
                $date_start='';
                if(isset($item['option_81']) && !empty($item['option_81'])){
                    $_strtotime = strtotime($item['option_81']);
                    $day = date('l',$_strtotime);
                    $day = strtolower($day);
                    $month = date('M',$_strtotime);
                    $month = strtolower($month);
                    $date_start =  lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '. date('d, g:i a', $_strtotime);
                }
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="featured__item <?php echo ($item['is_featured']==1) ? 'features':''; ?>">
                    <a href="<?php echo $item['url']; ?>" class="featured__item__img" alt="<?php _che($item['option_10']); ?>" style="background-image: url('<?php echo _simg($item['thumbnail_url'], '645x480', true); ?>')"></a>
                        <div class="featured__item__body">
                        <a href="<?php echo $item['url']; ?>" alt="<?php _che($item['option_10']); ?>" class="featured__item__title"><?php _che($item['option_10']); ?></a>
                        <?php if(!empty($date_start)):?>    
                            <div class="featured__item__info">
                            <span class="icon-fixed text-center mr-1"><i class="ion-android-time"></i></span>
                            <span><?php echo $date_start;?></span>
                            </div>
                        <?php endif;?>
                        <div class="featured__item__info mb-2">
                            <span class="icon-fixed text-center mr-1"><i class="ion-ios-location"></i></span>
                            <span><?php _che($item['address']); ?></span>
                        </div>
                        <p class="featured__item__description mb-2"><?php _che($item['option_chlimit_8']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div><!--widget-featured-property end-->
        <?php endif;?>
        </div>
    </div>
    
    <div class="section sect-rewards">
        <div class="container">
            <div class="sect_title">
                <h2><?php echo lang_check('Introducing Udora rewards');?></h2>
                <span class="subtitle"><?php echo lang_check('A section of places to stay verified for quality and design');?></span>
                <a href="#" class="btn btn-r_more"><?php echo lang_check('Lean more');?> <i class="fa fa-angle-right"></i></a>
            </div>
            <div class="rewards">
                <img src="assets/images/2-s.jpg" class="r_cover"/>
                <div class="r_body text-center"><a href="#" class="btn btn-r_more"><?php echo lang_check('Lean more');?> <i class="fa fa-angle-right"></i></a></div>
            </div>
        </div>
    </div>
    
    <div class="section sect-posts">
        <div class="container">
            <div class="sect_title">
                <h2><?php echo lang_check('Latest posts');?><a href="#" class="b-more pull-right"><?php echo lang_check('Show all');?> <i class="fa fa-angle-right"></i></a></h2>
            </div>
            <div class="row">
                <?php $i=0; foreach($news_module_latest_5 as $key=>$row):?> 
                <?php if ($i>4) break; ?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card-post">
                        <div class="thumbtnail"><a href="<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>"><img src="<?php echo _simg('files/'.$row->image_filename, '735x465', true); ?>" alt="<?php echo $row->title; ?>"></a></div>
                        <h3 class="cp_title"><a href=<?php echo site_url($lang_code.'/'.$row->id.'/'.url_title_cro($row->title)); ?>""><?php echo $row->title; ?></a></h3>
                        <div class="cp_text"><?php echo $row->description; ?></div>
                    </div>
                </div>
                <?php $i++; endforeach;?>
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
    
    <div class="d-none d-md-block">

        <!-- <section class="text-center pt-14 pb-14">
        <div class="container">
            <div class="row mb-5">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center">
                <div class="promo-block m-auto">
                <h2 class="weight-400 mb-2">Explore with Udora</h2>
                <div class="promo-paragraph">Do more, spend less. Experiences on a budget</div>
                <div class="center-line"></div>
            </div>
            </div>
            </div>
            <div class="row properties-items"> -->
                <!-- PROPERTY LISTING -->
           <!--         </div>
             <div class="text-center">
            <a class="btn btn-udora" href="<?php //echo site_url('frontend/login');?>" type="button">Start now for free!</a>
            </div>
        </div> -->
        <!--end of container-->
        <!-- </section> -->


        <section class="sectlion sect-eventmob">
            <div class="container">
                <div class="eventmob-body">
                    <div class="body">
                        <h3 class="weight-400">Never miss another <span class="color-accent">Event</span></h3>

                        <p>Join the Udora community where you can share your experiences, get recommendations and explore the world like a local.</p>

                        <p>Udora connets you with event organizers, local guides or explorers like yourself.</p>
                        <div class="text-center">
                        <a href="#" class="btn btn-udora"><?php echo lang_check('Get Started');?></a>
                        </div>
                    </div>

                    <div class="preview"><img alt="" class="img-responsive" src="assets/img/how-it-works/how-it-works-1.png"></div>
                </div>
            </div>
        </section>


        <section class="section sect-exploreh">
            <div class="container">
                <div class="row d-md-flex align-items-md-center">
                    <div class="col-md-6"><img style="margin-left: 74px;margin-top: 68px;" alt="" class="img-responsive mb-5 mb-md-0" src="assets/img/how-it-works/how-it-works-2.png"></div>

                    <div class="col-md-6 body">
                        <h3 class="weight-400">Explore the world with <span class="color-accent">Udora</span></h3>

                        <p>Udora is your travel companion and with customize search you can use Udora to search for vents by distance, category, date range or keywords.</p>
                        <div class="text-left">
                        <a href="#" class="btn btn-udora"><?php echo lang_check('Get Started');?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

   

    <!-- <section class="pt-14 pb-14">
    <div class="container">
        <div class="row">
        <div class="col-sm-6">
            <div class="other-serv marg0 bg-grey">
            <div class="serv-icon"><i class="ion-chatbubbles"></i></div>
            <div class="serv-block-list">
                <h2 class="serv-name">Join the conversation</h2>
                <p class="serv-desc weight-400">Make your voice heard, comment on events you are interested in. Share your opinion with others and give feedback. Your comments and feedback are important so post and be proud.</p>
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="other-serv marg0 bg-grey">
            <div class="serv-icon"><i class="ion-ios-location"></i></div>
            <div class="serv-block-list">
                <h2 class="serv-name">Never miss another event</h2>
                <p class="serv-desc weight-400">Is your favourite shop or brand giving away free samples? these are hidden gems you don't want to miss, that's why I created Udora, a social events discovery app for explorers like you.</p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section> -->


    <section class="cover cover-h imagebg text-center" data-overlay="6">
    <div class="background-image-holder" style="background: url(assets/img/home/inner-1.jpg); opacity: 1;">
        <img alt="background" src="assets/img/home/inner-1.jpg">
    </div>
    <div class="container pos-vertical-center">
        <div class="row">
        <div class="col-sm-6">
            <h3 class="">Want to know why we love Udora?</h3>
            <p class="lead">
            Check out this short video to see what Udora is all about and follow Udora to get updates on the app launch.
            </p>
            <div class="modal-instance">
            <div class="video-play-icon video-play-icon--sm modal-trigger" data-fancybox="" href="https://www.youtube.com/watch?v=vlDzYIIOYmM"></div>
            <!--end of modal-container-->
            </div>
            <!--end of modal instance-->
        </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
    </section>
    <div class="d-none d-sm-block">
        <?php _widget('custom_footer'); ?>
    </div>

    </div>


<a href="#" class="js-toogle-footermenu">
    <i class="material-icons">
    playlist_add
    </i>
    <i class="close-icon"></i>
</a>


<?php _widget('custom_javascript');?>
 
 <?php //_widget('mautic_tracker_javascript');?>

</body>
</html>

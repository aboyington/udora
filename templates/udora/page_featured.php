<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <?php _widget('top_sliderads');?>
    <div class="container marg50">
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
                <?php if(false):?>
                <div class="col-xs-12">
                    <div class="text-center"><a href="#" class="feat_more"><?php echo lang_check('Show all featured events');?></a></div>
                </div>
                <?php endif;?>
            </div><!--widget-featured-property end-->
        </div>
    </div>
    <?php endif;?>
    
            <?php
        $CI = &get_instance();
        $CI->load->model('estate_m');
        $CI->load->model('option_m');

        $last_n = 9;
        $top_n_estates = $this->estate_m->get_by(array('is_activated' => 1, /*'is_featured' => 1,*/ 'language_id'=>$lang_id), FALSE, $last_n, 'RAND()', NULL, array());
        $options_name = $this->option_m->get_lang(NULL, FALSE, $lang_id);

        $top_estates_num = $last_n;
        $top_estates = array();
        $CI->generate_results_array($top_n_estates, $top_estates, $options_name); 

        ?>
        <?php if(sw_count($top_estates)):?>
        <div class="section sect-featured sect-featured-w">
            <div class="container">
                <div class="sect_title"><h2><?php echo lang_check('Featured events around the world');?></h2></div>
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
        <div class="col-xs-12">
            <div class="text-center"><a href="#" class="feat_more udora_style xl"><?php echo lang_check('Load more featured events');?></a></div>
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
    <?php _widget('custom_javascript');?>
    <?php _widget('tawk_javascript');?>
</body>
</html>

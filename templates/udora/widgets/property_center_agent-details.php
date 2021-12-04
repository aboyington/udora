{has_agent}
<div class="clearfix profile-settings profile-settings-center profile-settings-widget">
    <div class="promo-text-blog col-xs-12">{lang_Organizer}</div>
    <div class="profile-wrapper">
        <div class="thumbnail_pr">
            <img src="{agent_image_url}" alt="" class="profile-img">
        </div>
        <div class="body">
            <div class="profile-statistics">
                <h4 id="member-name" class="member-name"><a href="{agent_url}"><?php  _che($agent_name_surname);?></a></h4>
                <p id="member-number"><?php  _che($agent_phone);?></p>
                <p id="member-points"><a href="mailto:<?php  _che($agent_mail);?>?subject={lang_Estateinqueryfor}: {estate_data_id}, {page_title}" title="<?php  _che($agent_mail);?>"><?php  _che($agent_mail);?></a></p>
                <?php //profile_cf_li(); ?>
                <!-- Example to print specific custom field with label -->
                <?php //profile_cf_single(1, TRUE); ?>
            </div>
        </div>
    </div>
</div>
{/has_agent}

<?php if(sw_count($agent_estates) > 0): ?>
<div class="wp-block other-listings">
<h4 class="title"><?php echo lang_check('More from this organizer');?></h4>
<div class="section sect-featured">
    <div class="row">
    <?php foreach($agent_estates as $key=>$item): ?>
    <?php
        if($key==2) break;
    ?>
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
        <div class="col-md-6 col-sm-6 col-xs-6">
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
    <?php
        endforeach;
    ?>   
    </div>
 </div>
<?php endif;?>
</div>
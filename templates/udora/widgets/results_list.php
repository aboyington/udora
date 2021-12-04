<?php foreach($results as $key=>$item): ?>
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

<div class="medium-blog marg-b-2 medium-blog-list col-xs-12">
    <div class="item-wrapper <?php echo ($item['is_featured']==1) ? 'features':''; ?>">
        <div class="col-lg-4 col-md-4 pad0 medium-blog-im">
            <div class="cl-blog-img"><a href="<?php echo $item['url']; ?>" alt="<?php _che($item['option_10']); ?>"><img src="<?php echo _simg($item['thumbnail_url'], '510x350'); ?>" alt="<?php _che($item['option_10']); ?>"></a></div>
        </div>
        <div class="col-lg-8 col-md-8 pad0">
            <div class="med-blog-naz">
                <div class="cl-blog-name marg0"><a href="<?php echo $item['url']; ?>" alt="<?php _che($item['option_10']); ?>"><?php _che($item['option_10']); ?></a></div>
                <div class="cl-blog-detail">
                    <span class="option"><?php echo lang_check('Category');?>: <?php _che($item['option_2']); ?></span>
                    <?php if(!empty($date_start)):?>
                    <span class="option"><?php echo lang_check('Start date');?>: <?php echo $date_start;?></span>
                    <?php endif;?>
                </div>
                <div class="cl-blog-text"><?php _che($item['option_chlimit_8']); ?></div>
            </div>
            <div class="footer clearfix cl-blog-detail">
                <a href="#" class="pull-left"> <span><i class="ion-ios-location-outline"></i></span><?php _che($item['address']); ?></a>
                <div class="controls-more">
                    <ul>
                        <li><a href="<?php echo $item['url']; ?>" data-id="14" class="add-to-favorites add-favorites-action">Add to favorites</a></li>
                        <li><a href="https://www.facebook.com/share.php?u=<?php echo $item['url']; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="add-to-watchlist">Share to friends</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
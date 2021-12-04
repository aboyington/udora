<?php
$col_sm = '4';
if(isset($columns) && $columns == 3)
{
    $col_sm = '4';
}

if(isset($columns) && $columns == 4)
{
    $col_sm = '3';
}
if(isset($columns) && $columns == 2)
{
    $col_sm = '6';
}

if(isset($columns) && $columns == 12)
{
    $col_sm = '12';
}
$class='';
if(isset($custom_class) && !empty($custom_class))
{
    $class = $custom_class;
} else {
    $class = 'col-md-'.$col_sm;
}
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

<div class="mb-4 col-xs-12 <?php echo $class; ?>">
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
        <div class="controls-more">
            <ul>
                <li><a href="<?php echo $item['url']; ?>" data-id="14" class="add-to-favorites add-favorites-action">Add to favorites</a></li>
                <li><a href="https://www.facebook.com/share.php?u=<?php echo $item['url']; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="add-to-watchlist">Share to friends</a></li>
            </ul>
        </div>
        </div>
    </div>
</div>
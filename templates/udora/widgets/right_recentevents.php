<?php
/*
Widget-title: Recent Events
Widget-preview-image: /assets/img/widgets_preview/right_recentevents.jpg
*/
?>

<div class="promo-text-blog"><?php echo lang_check('Recently Added');?></div>
<ul class="blog-category">
    <?php foreach($last_estates as $item): ?>
    <li><i class="ion-ios-arrow-right"></i> <a href="<?php echo $item['url']; ?>"><?php echo _ch($item['option_10'],''); ?></a></li>
    <?php endforeach;?>
</ul>
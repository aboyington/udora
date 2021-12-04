<?php
/*
Widget-title: Recent Events with preview image
Widget-preview-image: /assets/img/widgets_preview/right_recentevents2.jpg
*/
?>

<div class="promo-text-blog"><?php echo lang_check('Recent');?></div>
<div class="properties-list-small clearfix">
    <?php foreach($last_estates as $item): ?>
    <div class="property">
        <a href="<?php echo $item['url']; ?>" class="image image-hoveffect-zoom image-cover-div">
            <img src="<?php echo _simg($item['thumbnail_url'], '80x66'); ?>" alt="<?php echo _ch($item['option_10']); ?>">
        </a><!-- /.image -->
        <div class="body">
            <div class="title">
                <h3>
                    <a href="<?php echo $item['url']; ?>"><?php echo _ch($item['option_10']); ?></a>
                </h3>
            </div><!-- /.title -->
            <div class="location"><?php echo _ch($item['address']); ?></div><!-- /.location -->
            <div class="price">
                <?php if(!empty($item['option_36']) || !empty($item['option_37'])): ?>
                <?php 
                    if(!empty($item['option_36']))echo $options_prefix_36.price_format($item['option_36'], $lang_id).$options_suffix_36;
                    if(!empty($item['option_37']))echo ' '.$options_prefix_37.price_format($item['option_37'], $lang_id).$options_suffix_37
                ?>
                <?php else: ?>
                <?php endif; ?>                
            </div><!-- /.price -->
        </div><!-- /.wrapper -->
    </div>
    <?php endforeach;?>
</div>
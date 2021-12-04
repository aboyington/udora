<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body class='page_id_<?php _che($page_id);?>'>
    <?php _widget('header_menu');?>
    <!-- Help -->
    <div class="help-n-support" style="text-align: left;">
            <?php if(!empty($page_images)):?>
            <div class="page-image">
                <img src="<?php _che($page_images[0]->url);?>" alt="">
            </div>
            <?php endif;?>
            <!--<h3 class="help-header">{page_title}</h3>-->
            <div class="">
                {page_body}
                {has_page_documents}
                <h2>{lang_Filerepository}</h2>
                <ul>
                {page_documents}
                <li>
                    <a href="{url}">{filename}</a>
                </li>
                {/page_documents}
                </ul>
                {/has_page_documents}
            </div>
        <?php echo _widget('bottom_imagegallery');?>
        <?php echo _widget('bottom_disqus_comments');?>
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
</body>
</html>

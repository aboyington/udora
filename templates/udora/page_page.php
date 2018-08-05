<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
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
    <?php _widget('custom_footer_menu');?>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
</body>
</html>

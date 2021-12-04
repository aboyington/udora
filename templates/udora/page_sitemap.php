<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <!-- Help -->
    <div class="container help-n-support" style="text-align: left;">
        <div class="" style="padding-bottom: 20px;">
            <div class="title-page">
                <h2 class="help-header">{page_title}</h2>
            </div>
            <div class="box-content treefield-content">
                {page_body}
                <hr/>
                {has_page_documents}
                <h4>{lang_Filerepository}</h4>
                <ul>
                {page_documents}
                <li>
                    <a href="{url}">{filename}</a>
                </li>
                {/page_documents}
                </ul>
                {/has_page_documents}
                <div class="treefield_sitemap">
                    <?php echo treefield_sitemap(64, $lang_id, 'ul'); ?>
                    <br/>
                    <h4> <?php echo lang_check('Website sitemap');?> </h4>
                    <hr/>
                    <?php echo website_sitemap($lang_id, 'ul'); ?>
                </div>
            </div>
        </div>
        <?php echo _widget('bottom_imagegallery');?>
    </div>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
</body>
</html>

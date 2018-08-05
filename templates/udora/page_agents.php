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
            <h3 class="help-header">{page_title}</h3>
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
        </div>
        <?php echo _widget('bottom_imagegallery');?>
    </div>
    <?php _widget('custom_footer_menu');?>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
</body>
</html>

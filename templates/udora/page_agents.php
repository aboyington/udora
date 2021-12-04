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

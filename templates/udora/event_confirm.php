<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <div class="container marg50">
        <div class="help-n-support" style="text-align: left;">
            <!--<h3 class="help-header">{page_title}</h3>-->
            <div class="">
                {page_body}
            </div>
        </div>
    </div>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
</body>
</html>

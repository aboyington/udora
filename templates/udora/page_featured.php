<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <?php _widget('top_sliderads');?>
    <div class="container marg50">
        <div class="row">
            <div class="col-lg-9 marg-b-4">
                <?php echo _widget('center_featured');?>
            </div>
            <!-- Features Section Sidebar -->
            <div class="col-lg-3">
                <?php echo _widget('right_recentevents');?>
                <?php echo _widget('right_mostevents');?>
                <?php echo _widget('right_ads');?>
            </div>
        </div>
    </div>
    <?php _widget('custom_footer_menu');?>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
    <?php _widget('tawk_javascript');?>
</body>
</html>

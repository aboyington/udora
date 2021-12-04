<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
</head>
<body>
    <?php _widget('header_menu');?>
    <div class="container marg50">
        <?php _widget('top_search');?>
        <div class="row">
            <div class="col-lg-9 marg-b-4">
                <div class="" id="results_conteiner">
                    <?php echo _widget('center_recentproperties');?>
                    <?php echo _widget('center_bodycontent');?>
                    <?php echo _widget('center_imagegallery');?>
                    <div class="result_preload_indic"></div>
                </div>
            </div>
            <!-- Features Section Sidebar -->
            <div class="col-lg-3">
                <?php echo _widget('right_recentevents');?>
                <?php echo _widget('right_ads');?>
            </div>
        </div>
    </div>
    <?php _widget('custom_footer');?>
    <?php _widget('custom_javascript');?>
</body>
</html>

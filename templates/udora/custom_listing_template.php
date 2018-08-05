<!DOCTYPE html>
<html>
<head>
    <?php _widget('head');?>
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/dpejes/dpe.js')): ?>
    <script src="assets/js/dpejes/dpe.js"></script>
    <?php endif; ?>
    <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/places.js')): ?>
    <script src="assets/js/places.js"></script>
    <?php endif; ?>
</head>
<body>
<!-- Custom HTML -->
<?php _widget('header_menu');?>
<!-- Carousel -->
<div class="page-in event-header page-in-do-terra">
   <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-in-name">{page_title}</div>
                <div class="page-in-details">
                    <?php
                    if(isset($estate_data_option_81) && !empty($estate_data_option_81) && isset($estate_data_option_82) && !empty($estate_data_option_82)):
                        $_strtotime = strtotime($estate_data_option_81);
                        $day = date('l',$_strtotime);
                        $day = strtolower($day);
                        $month = date('F',$_strtotime);
                        $month = strtolower($month);
                        $date_start =  lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '. date('d, g:i a', $_strtotime);
                        echo $date_start;
                    ?>
                    <br> 
                     <?php
                        $_strtotime = strtotime($estate_data_option_82);
                        $day = date('l',$_strtotime);
                        $day = strtolower($day);
                        $month = date('F',$_strtotime);
                        $month = strtolower($month);
                        $end_start =  lang_check('cal_'.$day).', '.lang_check('cal_'.$month).' '. date('d, g:i a', $_strtotime);
                        echo $end_start;
                    endif;
                    ?>
                    <br>{estate_data_address}</div>
            </div>
        </div>
    </div>
</div>
<!-- Features Section Events -->
<div class="container marg50">
    <div class="row">
        <div class="col-lg-9 event-text border-right">
            <?php
            foreach ($widgets_order->center as $widget_filename) {
                _widget('property_'.$widget_filename);
            }
            ?>
        </div>
        <div class="col-lg-3">
            <?php
            foreach ($widgets_order->right as $widget_filename) {
                _widget('property_'.$widget_filename);
            }
            ?>
        </div>
    </div>
</div>
<?php _widget('custom_footer');?>
<?php _widget('custom_javascript');?>
<?php if(file_exists(APPPATH.'controllers/admin/reviews.php')): ?>
    <script src="assets/libraries/ratings/bootstrap-rating-input.js"></script> 
<?php endif; ?>
</body>
</html>

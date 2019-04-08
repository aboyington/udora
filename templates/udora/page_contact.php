<!DOCTYPE html>

<html>

<head>

    <?php _widget('head');?>

</head>

<body>

<?php _widget('header_menu');?>

<?php _widget('top_contactmap');?>

<div class="contact-section">

    <div class="col-xs-12 col-md-5 contact-data">

        <?php _widget('right_contactinfo');?>

    </div>

    <div class="col-xs-12 col-md-7">

        <?php _widget('center_contactform');?>

    </div>

</div>

    <div class="d-block d-md-none">

        <?php// _widget('custom_footer_menu');?>

    </div>

    <div class="d-none d-md-block">

        <?php _widget('custom_footer'); ?>

    </div>

<?php _widget('custom_javascript');?>

</body>

</html>


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
    
<style>
    
.description__item {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
        -ms-flex-align: center;
            align-items: center;
    margin-bottom: .6rem;
}

.description__item__icon {
    min-width: 22px;
    width: 22px;
    margin-right: 7px;
    text-align: center;
}

.description__item__icon i {
    font-size: 22px;
    color: #f25a28;
    line-height: 1;
}

.description__item h5 {
    padding: 0;
    margin: 0;
    line-height: 24px;
}

.mobile-social .promo-text-blog {
    display: none;
}
    
.mobile-social .btn.button-standart.add-event-btn{
    float: left;
    width: initial !important;
}
    
.mobile-social .raw {
    float: right;
}

#codeigniter_profiler {
    display: none;
}
    
hr {
    display: none;
}

.event-text > div {
    margin-left: -15px;
    margin-right: -15px;
}

</style>


</head>
<body>
<!-- Features Section Events -->
<div class="container property-content">
    <div class="row">
        <div class="col-lg-9 event-text border-right">
            <?php _widget('property_center_slider');?>
            <?php _widget('property_center_description_date');?>
            <?php _widget('property_center_map');?>
            <?php _widget('property_center_reviews');?>
            <?php _widget('property_center_agent-details');?>
            <?php _widget('property_center_disquscomments');?>
        </div> 
        <div class="col-lg-3">
            <div class="hidden-md hidden-sm hidden-xs">
                <?php _widget('property_right_qrcode');?>
                <?php _widget('property_right_favorites');?>
            </div>
            <div class="hidden-xs">
                <br style="clear:both"/>
                <?php _widget('property_right_enquiry-form');?>
            </div>
            <?php _widget('property_right_ads');?>
        </div>
    </div>
</div>
<?php _widget('custom_javascript');?>
<?php if(file_exists(APPPATH.'controllers/admin/reviews.php')): ?>
    <script src="assets/libraries/ratings/bootstrap-rating-input.js"></script> 
<?php endif; ?>
<script>
    $('a').attr("target","_blank");
</script>
</body>
</html>

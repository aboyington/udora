<meta charset="utf-8">
<title>{page_title}</title>
<meta name="description" content="{page_description}" />
<meta name="keywords" content="{page_keywords}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="mobile-web-app-capable" content="yes">

<!-- Open Graph Start -->
<!-- <meta property="og:title" content="Udora" />
<meta property="og:description" content="A simply event finder app" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://udora.io/production" />
<meta property="og:image" content="https://udora.io/production/templates/udora/assets/img/favicon/android-chrome-512x512.png" />
<meta property="fb:admins" content="Facebook admin Id number" /> -->
<!-- Open Graph End -->

<!-- Template Basic Images Start -->
<link rel="shortcut icon" href="<?php echo $website_favicon_url;?>" type="image/png" />
<link rel="apple-touch-icon" href="assets/img/favicon/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon/apple-touch-icon-180x180.png">

<link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicon/android-chrome-192x192.png">
<link rel="icon" type="image/png" sizes="512x512" href="assets/img/favicon/android-chrome-512x512.png">

<link rel="manifest" href="assets/img/manifest.json">
<link rel="mask-icon" href="assets/img/favicon/safari-pinned-tab.svg" color="#f15a24">
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="#f15a24">
<meta name="msapplication-TileColor" content="#f15a24">
<!-- <meta name="msapplication-TileImage" content="/mstile-144x144.png"> -->
<meta name="application-name" content="Udora">
<!-- Windows 8 and 10 -->
<meta name="msapplication-config" content="assets/img/browserconfig.xml">
<!-- Windows 8 and 10 -->
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-title" content="Udora">
<meta name="apple-mobile-web-app-status-bar-style" content="#f15a24">
<!-- Custom Browsers Color End -->
<meta name="theme-color" content="#000000">
<!-- Template Basic Images End -->

<!-- Header CSS (first screen styles from header.min.css) - inserted in the build of the project -->
<style>::-webkit-input-placeholder{color:#dcdcdc;opacity:1}:-moz-placeholder{color:#dcdcdc;opacity:1}::-moz-placeholder{color:#dcdcdc;opacity:1}:-ms-input-placeholder{color:#dcdcdc;opacity:1}body input:focus:required:invalid,body input:required:valid,body textarea:focus:required:invalid,body textarea:required:valid{color:#666}</style>
<!-- Load Fonts CSS Start -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<?php cache_file('big_css.css', 'assets/css/fonts.min.css'); ?>
<!-- Load Fonts CSS End -->
<?php cache_file('big_css.css', 'assets/libraries/font-awesome/css/font-awesome.min.css'); ?>
<!-- Load Custom CSS Start -->
<?php cache_file('big_css.css', 'assets/css/normalize.css'); ?>
<?php cache_file('big_css.css', 'assets/css/bootstrap.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/ionicons.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/trackpad-scroll-emulator.css'); ?>
<?php cache_file('big_css.css', 'assets/css/home-advanced-search.css'); ?>
<?php cache_file('big_css.css', 'assets/css/bootstrap-datetimepicker.css'); ?>
<?php cache_file('big_css.css', 'assets/css/bootstrap-select.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/main.css'); ?>
<?php cache_file('big_css.css', 'assets/css/map-page.css'); ?>
<?php cache_file('big_css.css', 'assets/css/lightslider.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/jquery.fancybox.min.css'); ?>
<?php cache_file('big_css.css', 'assets/css/custom.min.css'); ?>
<!-- Load Custom CSS End -->
<?php cache_file('big_js.js', 'assets/js/jquery-2.2.1.min.js'); ?>
<?php cache_file('big_js.js', 'assets/js/jquery-migrate-1.2.1.min.js'); ?>
<?php cache_file('big_js.js', 'assets/js/assets/bootstrap/bootstrap.min.js'); ?>

<?php 
$config_base_url = config_item('base_url');
$url_protocol='http://';
if(!empty($config_base_url)&& strpos( $config_base_url,'https')!== false){
    $url_protocol='https://';
}

$maps_api_key = config_db_item('maps_api_key');
$maps_api_key_prepare='';
if(!empty($maps_api_key)){
    $maps_api_key_prepare='&amp;key='.$maps_api_key;
}
?>

<!-- JS GMAP3  -->
<script src="<?php echo $url_protocol;?>maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing<?php echo $maps_api_key_prepare; ?>" type="text/javascript"></script>
<?php cache_file('big_js.js', 'assets/js/markerclusterer_packed.js'); ?>
<?php cache_file('big_js.js', 'assets/js/infobox.js'); ?>

<?php cache_file('big_js_custom.js', 'assets/libraries/bootstrap-3-typeahead/bootstrap3-typeahead.min.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/libraries/customd-jquery-number/jquery.number.min.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/libraries/h5Validate-master/jquery.h5validate.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/jquery.helpers.js'); ?>

<!-- Start bootstrap-datetimepicker-master -->
<?php cache_file('big_js_custom.js', 'assets/libraries/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js'); ?>
<!-- End bootstrap-datetimepicker-master -->

<!-- fileupload -->
<?php cache_file('big_css.css', 'assets/css/jquery.fileupload-ui.css'); ?>
<?php cache_file('big_css.css', 'assets/css/jquery.fileupload-ui-noscript.css'); ?> 

<?php cache_file('big_js_custom.js', 'assets/js/jquery.flexslider.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/load-image.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/jquery-ui-1.10.3.custom.min.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/fileupload/jquery.iframe-transport.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/fileupload/jquery.fileupload.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/fileupload/jquery.fileupload-fp.js'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/fileupload/jquery.fileupload-ui.js'); ?>
<!-- end fileupload -->

<!-- Start blueimp Gallery -->
<?php cache_file('big_js_custom.js', 'assets/js/blueimp-gallery.min.js'); ?>
<?php cache_file('big_css.css', 'assets/css/blueimp-gallery.min.css'); ?>
<!-- End blueimp Gallery-->

<!-- cleditor -->
<?php cache_file('big_css.css', 'assets/css/jquery.cleditor.css'); ?>
<?php cache_file('big_js_custom.js', 'assets/js/jquery.cleditor.min.js'); ?>
<!-- END cleditor -->

<!-- Start footable-jquery -->	
<?php cache_file('big_css.css', 'assets/libraries/footable-jquery/css/footable.bootstrap.min.css'); ?>
<?php cache_file('big_js_custom.js', 'assets/libraries/footable-jquery/js/footable.js'); ?>
<!-- End footable-jquery -->

<!-- Start hint -->
<?php cache_file('big_css.css', 'assets/libraries/hint/hint.min.css'); ?>
<!-- End hint -->

<!-- magnific-popup -->
<!-- url -- https://plugins.jquery.com/magnific-popup/ -->
<?php if(config_item('report_property_enabled') == TRUE): ?>
<?php cache_file('big_js_custom.js', 'assets/libraries/magnific-popup/jquery.magnific-popup.js'); ?>
<?php cache_file('big_css.css', 'assets/libraries/magnific-popup/magnific-popup.css'); ?>
<?php endif;?>
<!--end magnific-popup -->

<?php cache_file('big_js_custom.js', 'assets/js/custom_template.js'); ?>
<?php cache_file('big_css.css', NULL); ?>
<?php cache_file('big_js.js', NULL); ?>

<?php
/* remove google tracking
{settings_tracking}
<?php if($this->session->userdata('id')):?>
<script>
  gtag('set', 'user_id', '<?php echo $this->session->userdata('id');?>');
</script>
<?php endif;?>
*/
?>

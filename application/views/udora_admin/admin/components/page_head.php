<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('adminudora-assets/img/favicon/favicon.png')?>">
    <title><?php echo lang('app_name')?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('adminudora-assets/libraries/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url('adminudora-assets/libraries/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url('adminudora-assets/libraries/nprogress/nprogress.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('adminudora-assets/libraries/animate.css/animate.min.css')?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url('adminudora-assets/css/custom.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('adminudora-assets/css/custom2.css')?>" rel="stylesheet">
    
     <!-- jQuery -->
    <script src="<?php echo base_url('adminudora-assets/libraries/jquery/dist/jquery.min.js'); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url('adminudora-assets/libraries/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
  <?php
    $CI =& get_instance();
    $lang_code = $CI->language_m->get_code($CI->language_m->get_content_lang());
    ?>
    
    
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
    <script type="text/javascript" src="<?php echo $url_protocol;?>maps.google.com/maps/api/js?language=<?php echo $lang_code; ?><?php echo $maps_api_key_prepare; ?>&amp;libraries=places,geometry"></script>

</head>
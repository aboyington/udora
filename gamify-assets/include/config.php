<?php
error_reporting(E_ERROR | E_PARSE);
$root = dirname(dirname(__FILE__)) . '/';
$upload_root = dirname($root);
define('ROOTPATH', $root);
define('INCLUDE_ROOT', ROOTPATH . "include/");
/* Define upload directory path */
define ('UPLOAD_DIRECTORY_PATH', $upload_root . "adminudora-assets/gamify/");

/* Define root domain path */
define('SITE_DOMAIN', 'http://jgamify-codeigniter-mediasoftpro.c9users.io/gamify-assets/'); 
/* Define site upload directo path for accessing */
define ('SITE_DIRECTORY_PATH', SITE_DOMAIN . "contents/member/");
?>
<?php
header("Content-Type: application/json");
include_once("../../include/config.php");
include_once("../../include/entity/ga_badges_query.php");
include_once("../../include/bll/ga_badges_bll.php");
$obj = new ga_badges_bll();
$output = $obj->get_max_level();
echo json_encode(array('status' => 'success', 'level' => $output));

?>
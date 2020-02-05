<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin'); /* Important */
include "controller.php";
$url = $_GET['url'];
//$url = "https://vimeo.com/groups/29693/videos/304337100";
$data = controller($url);
if ($data != null) print_r(json_encode($data));


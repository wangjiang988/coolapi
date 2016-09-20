<?php
error_reporting(E_ERROR);
require_once WX_PAY_API_PATH.'/example/phpqrcode/phpqrcode.php';
$url = urldecode($_GET["data"]);
QRcode::png($url);

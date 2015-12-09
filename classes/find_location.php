<?php
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
echo $details->city;
echo $details->postal;//"{$details->city}, {$details->postal}";
?>

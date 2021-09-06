<?php

$sh = curl_share_init();
$errno = curl_share_errno($sh);
echo $errno . PHP_EOL;
echo curl_share_strerror($errno) . PHP_EOL;

@curl_share_setopt($sh, -1, -1);
$errno = curl_share_errno($sh);
echo $errno . PHP_EOL;
echo curl_share_strerror($errno) . PHP_EOL;
?>

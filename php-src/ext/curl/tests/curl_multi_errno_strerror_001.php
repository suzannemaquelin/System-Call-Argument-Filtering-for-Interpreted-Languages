<?php

$mh = curl_multi_init();
$errno = curl_multi_errno($mh);
echo $errno . PHP_EOL;
echo curl_multi_strerror($errno) . PHP_EOL;

@curl_multi_setopt($mh, -1, -1);
$errno = curl_multi_errno($mh);
echo $errno . PHP_EOL;
echo curl_multi_strerror($errno) . PHP_EOL;
?>

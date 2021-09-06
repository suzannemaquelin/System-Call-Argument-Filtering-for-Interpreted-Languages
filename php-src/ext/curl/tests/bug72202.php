<?php
$a = fopen(__FILE__, "r");
$b = $a;
var_dump($a, $b);
fclose($a);
var_dump($a, $b);
unset($a, $b);

$a = curl_init();
$b = $a;
var_dump($a, $b);
curl_close($a);
var_dump($a, $b);
unset($a, $b);
?>

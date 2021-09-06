<?php

// Forbidden class
class A {}

$p = 'x:i:0;a:1:{i:0;O:1:"A":0:{}};m:a:0:{}';
$s = 'C:11:"ArrayObject":' . strlen($p) . ':{' . $p . '}';
var_dump(unserialize($s, ['allowed_classes' => ['ArrayObject']]));

?>

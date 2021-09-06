<?php

$p = array(array());
array_push($p[0], array(100));

$c = array_merge($p, array());
$c[0][0] = 200;

print_r($p);

?>

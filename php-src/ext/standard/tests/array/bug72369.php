<?php
$x = 'xxx';
$d = ['test' => &$x];
unset($x);
$a = ['test' => 'yyy'];
$a = array_merge($a, $d);
debug_zval_dump($a);
?>

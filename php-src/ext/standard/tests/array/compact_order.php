<?php

$foo = null;
$bar = null;

var_dump(compact('foo', 'bar'));
var_dump(compact('bar', 'foo'));

?>

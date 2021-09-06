<?php

$obj = (object)['a' => 1, 'b' => 2];
$ao = new ArrayObject($obj);
$arr = (array) $obj;
$ao['a'] = 42;
var_dump($arr);

?>

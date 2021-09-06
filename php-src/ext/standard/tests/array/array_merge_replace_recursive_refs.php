<?php

$x = 24;
$arr1 = [[42]];
$arr2 = [[&$x]];
unset($x);
$arr3 = array_replace_recursive($arr1, $arr2);
$arr2[0][0] = 12;
var_dump($arr3);

unset($arr1, $arr2, $arr3);

$x = 24;
$arr1 = [42];
$arr2 = [&$x];
unset($x);
$arr3 = array_merge_recursive($arr1, $arr2);
$arr2[0] = 12;
var_dump($arr3);

?>

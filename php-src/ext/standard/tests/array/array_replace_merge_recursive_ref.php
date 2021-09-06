<?php

$one = [1];
$two = [42];
$arr1 = ['k' => &$one];
$arr2 = ['k' => &$two];
var_dump(current($one), current($two));
array_replace_recursive($arr1, $arr2);
var_dump(current($one), current($two));

$one = [1];
$two = [42];
$arr1 = ['k' => &$one];
$arr2 = ['k' => &$two];
var_dump(current($one), current($two));
array_merge_recursive($arr1, $arr2);
var_dump(current($one), current($two));

?>

<?php

$arr1 = array("key" => array(0, 1));
$arr2 = array("key" => array(2));

unset($arr1["key"][1]);

$result = array_merge_recursive($arr1, $arr2);
print_r($result);
?>

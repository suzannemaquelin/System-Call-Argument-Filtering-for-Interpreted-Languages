<?php

function walk (array $arr) {
	array_walk($arr, function (&$val, $name) {

	});

	return $arr;
}

$arr3 = ['foo' => 'foo'];
$arr4 = walk(['foo' => 'bar']);
$arr5 = array_replace_recursive($arr3, $arr4);
$arr5['foo'] = 'baz';

var_dump($arr3, $arr4, $arr5);

?>

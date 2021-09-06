<?php
$arr = array('id' => 12345, 'name' => 'sam');
foreach ($arr as &$v) {
	    $v = $v;
}

$arr = [$arr];

var_dump(array_column($arr, 'name', 'id'));
?>

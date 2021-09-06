<?php
function cast(&$a) {
		$a = (int)$a;
}

$a = new ArrayIterator;
$a[-1] = 123;

$b = "-1";
cast($b);

var_dump(isset($a[$b]));
$a[$b] = "okey";
var_dump($a[$b]);
unset($a[$b]);
var_dump(isset($a[$b]));
?>

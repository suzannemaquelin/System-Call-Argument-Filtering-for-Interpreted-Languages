<?php
echo "\nChange from array to non iterable:\n";
$a = array(1,2,3);
$b=&$a;
foreach ($a as $v) {
	var_dump($v);
	$b=1;
}

echo "\nChange from object to non iterable:\n";
$a = new stdClass;
$a->a=1;
$a->b=2;
$b=&$a;
foreach ($a as $v) {
	var_dump($v);
	$b='x';
}

?>

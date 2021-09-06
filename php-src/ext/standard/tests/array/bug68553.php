<?php
$i = 100;
/* increase the resource id to make test stable */
while ($i--) {
	$fd = fopen(__FILE__, "r");
	fclose($fd);
}
$a = [
	['a' => 10],
	['a' => 20],
	['a' => true],
	['a' => false],
	['a' => fopen(__FILE__, "r")],
	['a' => -5],
	['a' => 7.38],
	['a' => null, "test"],
	['a' => null],
];

var_dump(array_column($a, null, 'a'));

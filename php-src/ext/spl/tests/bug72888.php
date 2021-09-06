<?php
$x = new SplFileObject(__FILE__);

try {
	$y=clone $x;
} catch (Error $e) {
	var_dump($e->getMessage());
}
var_dump($y);
?>

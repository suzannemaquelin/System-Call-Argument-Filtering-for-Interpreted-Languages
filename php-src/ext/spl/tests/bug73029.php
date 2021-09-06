<?php
try {
$a = 'C:11:"ArrayObject":19:0x:i:0;r:2;;m:a:0:{}}';
$m = unserialize($a);
$x = $m[2];
} catch(UnexpectedValueException $e) {
	print $e->getMessage() . "\n";
}
?>
DONE

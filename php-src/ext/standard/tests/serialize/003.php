<?php
foreach(array(1e2, 5.2e25, 85.29e-23, 9e-9) AS $value) {
	echo ($ser = serialize($value))."\n";
	var_dump(unserialize($ser));
	echo "\n";
}
?>

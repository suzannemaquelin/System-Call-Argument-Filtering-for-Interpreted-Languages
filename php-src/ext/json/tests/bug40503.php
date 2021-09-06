<?php
function json_test_show_eq($x, $y) {
	echo "$x ". ( $x == $y ? "==" : "!=") ." $y\n";
}

$value = 0x7FFFFFFF; #2147483647;
json_test_show_eq("$value", json_encode($value));
$value++;
json_test_show_eq("$value", json_encode($value));

?>

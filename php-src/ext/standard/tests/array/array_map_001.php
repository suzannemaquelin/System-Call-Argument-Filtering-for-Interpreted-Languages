<?php

$a = array(1,2,3);

function foo() {
	throw new exception(1);
}

try {
	array_map("foo", $a, array(2,3));
} catch (Exception $e) {
	var_dump("exception caught!");
}

echo "Done\n";
?>

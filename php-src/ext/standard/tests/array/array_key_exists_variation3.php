<?php
/* Prototype  : bool array_key_exists(mixed $key, array $search)
 * Description: Checks if the given key or index exists in the array
 * Source code: ext/standard/array.c
 * Alias to functions: key_exists
 */

/*
 * Pass floats as $key argument, then cast float values
 * to integers and pass as $key argument
 */

echo "*** Testing array_key_exists() : usage variations ***\n";

$keys = array(1.2345678900E-10, 1.00000000000001, 1.99999999999999);

$search = array ('zero', 'one', 'two');

$iterator = 1;
foreach($keys as $key) {
	echo "\n-- Iteration $iterator --\n";
	echo "Pass float as \$key:\n";
	var_dump(array_key_exists($key, $search));
	echo "Cast float to int:\n";
	var_dump(array_key_exists((int)$key, $search));
}

echo "Done";
?>

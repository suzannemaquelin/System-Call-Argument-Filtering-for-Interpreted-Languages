<?php
/* Prototype  : mixed end(array $array_arg)
 * Description: Advances array argument's internal pointer to the last element and return it
 * Source code: ext/standard/array.c
 */

/*
 * Test end() when passed:
 * 1. a two-dimensional array
 * 2. a sub-array
 * as $array_arg argument.
 */

echo "*** Testing end() : usage variations ***\n";

$array_arg = array ('a' => 'z', array(9, 8, 7));

echo "\n-- Pass a two-dimensional array as \$array_arg --\n";
var_dump(end($array_arg));

echo "\n-- Pass a sub-array as \$array_arg --\n";
var_dump(end($array_arg[0]));
?>
===DONE===

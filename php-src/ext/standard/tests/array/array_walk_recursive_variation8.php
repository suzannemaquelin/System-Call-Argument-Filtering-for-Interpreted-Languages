<?php
/* Prototype  : bool array_walk_recursive(array $input, string $funcname [, mixed $userdata])
 * Description: Apply a user function to every member of an array
 * Source code: ext/standard/array.c
*/

/*
 * Passing different buit-in functionns as callback function
 *    pow function
 *    min function
 *    echo language construct
*/

echo "*** Testing array_walk_recursive() : built-in function as callback ***\n";

$input = array(array(2 => 1, 65), array(98, 100), array(6 => -4));

echo "-- With 'pow' built-in function --\n";
var_dump( array_walk_recursive($input, 'pow'));

echo "-- With 'min' built-in function --\n";
var_dump( array_walk_recursive($input, "min"));

echo "-- With 'echo' language construct --\n";
var_dump( array_walk_recursive($input, "echo"));

echo "Done"
?>

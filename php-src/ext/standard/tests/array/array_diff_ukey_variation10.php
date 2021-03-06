<?php
/* Prototype  : array array_diff_ukey(array arr1, array arr2 [, array ...], callback key_comp_func)
 * Description: Returns the entries of arr1 that have keys which are not present in any of the others arguments.
 * Source code: ext/standard/array.c
 */

echo "*** Testing array_diff_ukey() : usage variation ***\n";

//Initialize variables
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "yellow", "red");

//function name within double quotes
var_dump( array_diff_ukey($array1, $array1, "unknown_function") );

//function name within single quotes
var_dump( array_diff_ukey($array1, $array1, 'unknown_function') );

//function name without quotes
var_dump( array_diff_ukey($array1, $array1, unknown_function) );

?>
===DONE===

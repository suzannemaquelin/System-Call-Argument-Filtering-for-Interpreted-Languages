<?php
/* Prototype  : array array_intersect_ukey(array arr1, array arr2 [, array ...], callback key_compare_func)
 * Description: Computes the intersection of arrays using a callback function on the keys for comparison.
 * Source code: ext/standard/array.c
 */

echo "*** Testing array_intersect_ukey() : usage variation ***\n";

//Initialize variables
$arr_default_int = array(1, 2 );
$arr_float = array(0 => 1.00, 1.00 => 2.00, 2.00 => 3.00);
$arr_string = array('0' => '1', '1' => '2', '2' => '3');
$arr_string_float = array('0.00' => '1.00', '1.00' => '2.00');

//Call back function
function key_compare_func($key1, $key2)
{
    if ($key1 == $key2)
        return 0;
    else
        return ($key1 > $key2)? 1:-1;
}

echo "\n-- Result of integers and floating point intersection --\n";
var_dump( array_intersect_ukey($arr_default_int, $arr_float, "key_compare_func") );

echo "\n-- Result of integers and strings containing integers intersection --\n";
var_dump( array_intersect_ukey($arr_default_int, $arr_string, "key_compare_func") );

echo "\n-- Result of integers and strings containing floating points intersection --\n";
var_dump( array_intersect_ukey($arr_default_int, $arr_string_float, "key_compare_func") );
?>
===DONE===

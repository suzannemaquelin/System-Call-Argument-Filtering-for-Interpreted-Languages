<?php
/* Prototype  : array array_chunk(array input, int size [, bool preserve_keys])
 * Description: Split array into chunks
 * Source code: ext/standard/array.c
*/

echo "*** Testing array_chunk() : error conditions ***\n";

// Zero arguments
echo "\n-- Testing array_chunk() function with zero arguments --\n";
var_dump( array_chunk() );

echo "\n-- Testing array_chunk() function with more than expected no. of arguments --\n";
$input = array(1, 2);
$size = 10;
$preserve_keys = true;
$extra_arg = 10;
var_dump( array_chunk($input,$size,$preserve_keys, $extra_arg) );

echo "\n-- Testing array_chunk() function with less than expected no. of arguments --\n";
$input = array(1, 2);
var_dump( array_chunk($input) );

echo "Done";
?>

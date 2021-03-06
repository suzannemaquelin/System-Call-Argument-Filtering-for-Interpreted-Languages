<?php
/* Prototype  : int sizeof(mixed $var[, int $mode] )
 * Description: Counts an elements in an array. If Standard PHP library is
 *              installed, it will return the properties of an object.
 * Source code: ext/standard/basic_functions.c
 * Alias to functions: count()
 */

/* Testing the sizeof() for non-scalar type(array) value
 * in default, COUNT_NORMAL and COUNT_RECURSIVE modes.
 * Sizeof() has been tested for simple integer, string,
 * indexed and mixed arrays.
 */

echo "*** Testing sizeof() : basic functionality ***\n";

$int_array = array(1, 2, 3, 4);
$string_array = array("Saffron", "White", "Green");
$indexed_array = array("Aggression" => "Saffron", "Peace" => "White", "Growth" => "Green");
$mixed_array = array(1, 2, "Aggression" => "Saffron", 10 => "Ten", "Ten" => 10);

echo "-- Testing sizeof() with integer array in default, COUNT_NORMAL, COUNT_RECURSIVE modes --\n";
echo "default mode: ";
var_dump( sizeof($int_array) );
echo "\n";
echo "COUNT_NORMAL mode: ";
var_dump( sizeof($int_array, COUNT_NORMAL) );
echo "\n";
echo "COUNT_RECURSIVE mode: ";
var_dump( sizeof($int_array, COUNT_RECURSIVE) );
echo "\n";

echo "-- Testing sizeof() with string array in default, COUNT_NORMAL, COUNT_RECURSIVE modes --\n";
echo "default mode: ";
var_dump( sizeof($string_array) );
echo "\n";
echo "COUNT_NORMAL mode: ";
var_dump( sizeof($string_array, COUNT_NORMAL) );
echo "\n";
echo "COUNT_RECURSIVE mode: ";
var_dump( sizeof($string_array, COUNT_RECURSIVE) );
echo "\n";

echo "-- Testing sizeof() with indexed array in default, COUNT_NORMAL, COUNT_RECURSIVE modes --\n";
echo "default mode: ";
var_dump( sizeof($indexed_array) );
echo "\n";
echo "COUNT_NORMAL mode: ";
var_dump( sizeof($indexed_array, COUNT_NORMAL) );
echo "\n";
echo "COUNT_RECURSIVE mode: ";
var_dump( sizeof($indexed_array, COUNT_RECURSIVE) );
echo "\n";

echo "-- Testing sizeof() with mixed array in default, COUNT_NORMAL, COUNT_RECURSIVE modes --\n";
echo "default mode: ";
var_dump( sizeof($mixed_array) );
echo "\n";
echo "COUNT_NORMAL mode: ";
var_dump( sizeof($mixed_array, COUNT_NORMAL) );
echo "\n";
echo "COUNT_RECURSIVE mode: ";
var_dump( sizeof($mixed_array, COUNT_RECURSIVE) );

echo "Done";
?>

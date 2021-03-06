<?php
/* Prototype  : proto array array_fill_keys(array keys, mixed val)
 * Description: Create an array using the elements of the first parameter as keys each initialized to val
 * Source code: ext/standard/array.c
 * Alias to functions:
 */


echo "*** Testing array_fill_keys() : parameter variations ***\n";

$nullVal = null;
$simpleStr = "simple";
$fp = fopen(__FILE__, "r");
$emptyArr = array();
$bool = false;
$float = 2.4;

class classA {
  public function __toString() { return "Class A object"; }
}
$obj = new classA();


echo "\n-- Testing array_fill_keys() function with empty arguments --\n";
var_dump( array_fill_keys($emptyArr, $nullVal) );

echo "\n-- Testing array_fill_keys() function with keyed array --\n";
$keyedArray = array("two" => 2, "strk1" => "strv1", 4, $simpleStr);
var_dump( array_fill_keys($keyedArray, $simpleStr) );

echo "\n-- Testing array_fill_keys() function with mixed array --\n";
$mixedArray = array($fp, $obj, $simpleStr, $emptyArr, 2, $bool, $float);
var_dump( array_fill_keys($mixedArray, $simpleStr) );

fclose($fp);
echo "Done";
?>

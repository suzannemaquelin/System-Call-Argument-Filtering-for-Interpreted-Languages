<?php
/* Prototype  : array array_filter(array $input [, callback $callback])
 * Description: Filters elements from the array via the callback.
 * Source code: ext/standard/array.c
*/

/*
* callback functions are expected to return bool value for array_filter()
* here testing callback functions for return values other than bool
*/

echo "*** Testing array_filter() : usage variations - callback function with different return values***\n";

$input = array(0, 1, -1, 10, 100, 1000, 'Hello', null, true);

// callback functions
// int as return value
function callback1($input)
{
  return 5;
}
echo "callback function with int return value\n";
var_dump( array_filter($input, 'callback1') );

// float as return value
function callback2($input)
{
  return 3.4;
}
echo "callback function with float return value\n";
var_dump( array_filter($input, 'callback2') );

// string as return value
function callback3($input)
{
  return 'value';
}
echo "callback function with string return value\n";
var_dump( array_filter($input, 'callback3') );

// null as return value
function callback4($input)
{
  return null;
}
echo "callback function with null return value\n";
var_dump( array_filter($input, 'callback4') );

// array as return value
function callback5($input)
{
  return array(8);
}
echo "callback function with array as return value\n";
var_dump( array_filter($input, 'callback5') );

echo "Done"
?>

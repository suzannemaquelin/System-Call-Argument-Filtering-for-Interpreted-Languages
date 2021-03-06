<?php
/* Prototype  : bool ctype_xdigit(mixed $c)
 * Description: Checks for character(s) representing a hexadecimal digit
 * Source code: ext/ctype/ctype.c
 */

/*
 * Pass incorrect number of arguments to ctype_xdigit() to test behaviour
 */

echo "*** Testing ctype_xdigit() : error conditions ***\n";

// Zero arguments
echo "\n-- Testing ctype_xdigit() function with Zero arguments --\n";
var_dump( ctype_xdigit() );

//Test ctype_xdigit with one more than the expected number of arguments
echo "\n-- Testing ctype_xdigit() function with more than expected no. of arguments --\n";
$c = 1;
$extra_arg = 10;
var_dump( ctype_xdigit($c, $extra_arg) );
?>
===DONE===

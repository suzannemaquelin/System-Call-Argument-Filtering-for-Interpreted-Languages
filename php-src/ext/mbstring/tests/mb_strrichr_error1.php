<?php
/* Prototype  : string mb_strrichr(string haystack, string needle[, bool part[, string encoding]])
 * Description: Finds the last occurrence of a character in a string within another, case insensitive
 * Source code: ext/mbstring/mbstring.c
 * Alias to functions:
 */

echo "*** Testing mb_strrichr() : error conditions ***\n";


//Test mb_strrichr with one more than the expected number of arguments
echo "\n-- Testing mb_strrichr() function with more than expected no. of arguments --\n";
$haystack = b'string_val';
$needle = b'string_val';
$part = true;
$encoding = 'string_val';
$extra_arg = 10;
var_dump( mb_strrichr($haystack, $needle, $part, $encoding, $extra_arg) );

// Testing mb_strrichr with one less than the expected number of arguments
echo "\n-- Testing mb_strrichr() function with less than expected no. of arguments --\n";
$haystack = b'string_val';
var_dump( mb_strrichr($haystack) );

?>
===DONE===

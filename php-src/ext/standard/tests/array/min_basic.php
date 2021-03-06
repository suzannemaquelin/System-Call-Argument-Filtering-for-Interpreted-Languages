<?php
/*
 * proto mixed min(mixed arg1 [, mixed arg2 [, mixed ...]])
 * Function is implemented in ext/standard/array.c
*/

echo "\n*** Testing sequences of numbers ***\n";

var_dump(min(2,1,2));
var_dump(min(-2,1,2));
var_dump(min(2.1,2.11,2.09));
var_dump(min("", "t", "b"));
var_dump(min(false, true, false));
var_dump(min(true, false, true));
var_dump(min(1, true, false, true));
var_dump(min(0, true, false, true));
var_dump(min(0, 1, array(2,3)));

echo "\nDone\n";
?>

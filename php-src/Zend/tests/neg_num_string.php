<?php

$a = [
    "0" => 1,
    "-0" => 2,
    "1" => 3,
    "-1" => 4,
    "0x0" => 5,
    "-0x0" => 6,
    "00" => 7,
    "-00" => 8,
    "9223372036854775808" => 9,
    "-9223372036854775808" => 10,
    "2147483648" => 11,
    "-2147483648" => 12,
];

var_dump("$a[0]");
var_dump("$a[-0]");
var_dump("$a[1]");
var_dump("$a[-1]");
var_dump("$a[0x0]");
var_dump("$a[-0x0]");
var_dump("$a[00]");
var_dump("$a[-00]");
var_dump("$a[9223372036854775808]");
var_dump("$a[-9223372036854775808]");
var_dump("$a[2147483648]");
var_dump("$a[-2147483648]");

?>

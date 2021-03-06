<?php
/* Prototype  : mixed mb_substitute_character([mixed substchar])
 * Description: Sets the current substitute_character or returns the current substitute_character
 * Source code: ext/mbstring/mbstring.c
 * Alias to functions:
 */

echo "*** Testing mb_substitute_character() : variation ***\n";
//japenese utf-8
$string_mb = base64_decode('5pel5pys6Kqe44OG44Kt44K544OI');

//output the default which is ? in ISO-8859-1, x3f
var_dump(bin2hex(mb_convert_encoding($string_mb, "ISO-8859-1", "UTF-8")));

mb_substitute_character(66);  //'B' in ISO-8859-1, x42
var_dump(bin2hex(mb_convert_encoding($string_mb, "ISO-8859-1", "UTF-8")));
mb_substitute_character("none"); //no substitution
var_dump(bin2hex(mb_convert_encoding($string_mb, "ISO-8859-1", "UTF-8")));
mb_substitute_character(280); //not valid in ISO-8859-1
var_dump(bin2hex(mb_convert_encoding($string_mb, "ISO-8859-1", "UTF-8")));


?>
===DONE===

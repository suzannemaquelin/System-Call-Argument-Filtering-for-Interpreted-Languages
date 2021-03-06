<?php
/* Prototype  : int iconv_strlen(string str [, string charset])
 * Description: Get character numbers of a string
 * Source code: ext/iconv/iconv.c
 */

/*
 * Test basic functionality of iconv_strlen()
 */

echo "*** Testing iconv_strlen() : basic functionality***\n";

$string_ascii = b'abc def';
//Japanese string in UTF-8
$string_mb = base64_decode(b'5pel5pys6Kqe44OG44Kt44K544OI44Gn44GZ44CCMDEyMzTvvJXvvJbvvJfvvJjvvJnjgII=');

echo "\n-- ASCII String --\n";
var_dump(iconv_strlen($string_ascii));

echo "\n-- Multibyte String --\n";
var_dump(iconv_strlen($string_mb, 'UTF-8'));
?>
===DONE===

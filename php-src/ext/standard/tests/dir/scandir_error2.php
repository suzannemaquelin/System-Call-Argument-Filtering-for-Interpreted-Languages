<?php
/* Prototype  : array scandir(string $dir [, int $sorting_order [, resource $context]])
 * Description: List files & directories inside the specified path
 * Source code: ext/standard/dir.c
 */

/*
 * Pass a directory that does not exist to scandir() to test error messages
 */

echo "*** Testing scandir() : error conditions ***\n";

$directory = dirname(__FILE__) . '/idonotexist';

echo "\n-- Pass scandir() an absolute path that does not exist --\n";
var_dump(scandir($directory));

echo "\n-- Pass scandir() a relative path that does not exist --\n";
var_dump(scandir('/idonotexist'));
?>
===DONE===

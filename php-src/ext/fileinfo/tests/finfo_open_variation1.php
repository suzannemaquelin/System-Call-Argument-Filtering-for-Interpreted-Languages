<?php
/* Prototype  : resource finfo_open([int options [, string arg]])
 * Description: Create a new fileinfo resource.
 * Source code: ext/fileinfo/fileinfo.c
 * Alias to functions:
 */

$magicFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'magic';

echo "*** Testing finfo_open() : variations in opening ***\n";

// Calling finfo_open() with different options
var_dump( finfo_open( FILEINFO_MIME | FILEINFO_SYMLINK, $magicFile ) );
//var_dump( finfo_open( FILEINFO_COMPRESS | FILEINFO_PRESERVE_ATIME, $magicFile ) );
var_dump( finfo_open( FILEINFO_DEVICES | FILEINFO_RAW, $magicFile ) );

?>
===DONE===

<?php
/* Prototype  : resource finfo_close(resource finfo)
 * Description: Close fileinfo resource.
 * Source code: ext/fileinfo/fileinfo.c
 * Alias to functions:
 */

echo "*** Testing finfo_close() : basic functionality ***\n";

$magicFile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'magic';

$finfo = finfo_open( FILEINFO_MIME, $magicFile );
var_dump( $finfo );

// Calling finfo_close() with all possible arguments
var_dump( finfo_close($finfo) );

$finfo = new finfo( FILEINFO_MIME, $magicFile );
var_dump( $finfo );
unset( $finfo );

?>
===DONE===

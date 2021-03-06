<?php
/* Prototype: array lstat ( string $filename );
   Description: Gives information about a file or symbolic link

   Prototype: array stat ( string $filename );
   Description: Gives information about a file
*/

/* test the effects of rename() on stats of link */

$file_path = dirname(__FILE__);
require "$file_path/file.inc";

/* create temp file & link */
$fp = fopen("$file_path/lstat_stat_variation3.tmp", "w");  // temp file
fclose($fp);

// temp link
symlink("$file_path/lstat_stat_variation3.tmp", "$file_path/lstat_stat_variation_link3.tmp");

// renaming a link
echo "*** Testing lstat() for link after being renamed ***\n";
$old_linkname = "$file_path/lstat_stat_variation_link3.tmp";
$new_linkname = "$file_path/lstat_stat_variation_link3a.tmp";
$old_stat = lstat($old_linkname);
clearstatcache();
var_dump( rename($old_linkname, $new_linkname) );
$new_stat = lstat($new_linkname);

// compare self stats
var_dump( compare_self_stat($old_stat) );
var_dump( compare_self_stat($new_stat) );

// compare the two stats - all except ctime
$keys_to_compare = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12,
                       "dev", "ino", "mode", "nlink", "uid", "gid",
                       "rdev", "size", "atime", "mtime", "blksize", "blocks");
var_dump( compare_stats($old_stat, $new_stat, $keys_to_compare) );
?>
===Done===

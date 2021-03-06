<?php
/* Prototype: int fileperms ( string $filename )
 * Description: Returns the group ID of the file, or FALSE in case of an error.
 */

/* Passing file names with different notations, using slashes, wild-card chars */

$file_path = dirname(__FILE__);

echo "*** Testing fileperms() with different notations of file names ***\n";
$dir_name = $file_path."/fileperms_variation3";
mkdir($dir_name);
$file_handle = fopen($dir_name."/fileperms_variation3.tmp", "w");
fclose($file_handle);

$files_arr = array(
  "/fileperms_variation3/fileperms_variation3.tmp",

  /* Testing a file trailing slash */
  "/fileperms_variation3/fileperms_variation3.tmp/",

  /* Testing file with double slashes */
  "/fileperms_variation3//fileperms_variation3.tmp",
  "//fileperms_variation3//fileperms_variation3.tmp",
  "/fileperms_variation3/*.tmp",
  "fileperms_variation3/fileperms*.tmp",

  /* Testing Binary safe */
  "/fileperms_variation3/fileperms_variation3.tmp".chr(0),
  "/fileperms_variation3/fileperms_variation3.tmp\0"
);

$count = 1;
/* loop through to test each element in the above array */
foreach($files_arr as $file) {
  echo "- Iteration $count -\n";
  var_dump( fileperms( $file_path."/".$file ) );
  clearstatcache();
  $count++;
}

echo "\n*** Done ***";
?>

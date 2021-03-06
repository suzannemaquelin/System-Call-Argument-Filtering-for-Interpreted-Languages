<?php
/*
 Prototype: bool ftruncate ( resource $handle, int $size );
 Description: Truncates a file to a given length
*/

// include common file related test functions
include ("file.inc");

echo "*** Testing ftruncate() : usage variations ***\n";

/* test ftruncate with file opened in different modes */
$file_modes = array("r", "rb", "rt", "r+", "r+b", "r+t",
                    "w", "wb", "wt", "w+", "w+b", "w+t",
                    "x", "xb", "xt", "x+", "x+b", "x+t",
                    "a", "ab", "at", "a+", "a+b", "a+t");

$file_content_types = array("numeric","text_with_new_line");

foreach($file_content_types as $file_content_type) {
 echo "\n-- Testing ftruncate() with file having data of type ". $file_content_type ." --\n";

 for($mode_counter = 0; $mode_counter < count($file_modes); $mode_counter++) {
   echo "-- Testing ftruncate() with file opening using $file_modes[$mode_counter] mode --\n";

   // create 1 file with some contents
   $filename = dirname(__FILE__)."/ftruncate_variation5.tmp";
   if( strstr($file_modes[$mode_counter], "x") || strstr($file_modes[$mode_counter], "w") ) {
     // fopen the file using the $file_modes
     $file_handle = fopen($filename, $file_modes[$mode_counter]);
     fill_file($file_handle, $file_content_type, 1024);
   } else {
     create_files ( dirname(__FILE__), 1, $file_content_type, 0755, 1, "w", "ftruncate_variation", 5);
     // fopen the file using the $file_modes
     $file_handle = fopen($filename, $file_modes[$mode_counter]);
   }
   if (!$file_handle) {
     echo "Error: failed to open file $filename!\n";
     exit();
   }

   rewind($file_handle); // file pointer to 0

   echo "-- Testing ftruncate(): try truncating file to size, bigger than existing --\n";
   /* try to truncate it to size bigger then current */

   $new_size = filesize($filename) + 100;
   var_dump( filesize($filename) );  // current filesize
   var_dump( ftell($file_handle) );
   var_dump( ftruncate($file_handle, $new_size) ); // truncate it
   var_dump( ftell($file_handle) );
   var_dump( feof($file_handle) );
   fclose($file_handle);
   clearstatcache(); // clear previous size value in cache
   var_dump( filesize($filename) ); // new file size = actual size, no change

   //delete all files created
   delete_file($filename);
 }//end of inner for loop

}//end of outer foreach loop
echo "Done\n";
?>

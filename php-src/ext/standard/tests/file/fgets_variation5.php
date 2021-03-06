<?php
/*
 Prototype: string fgets ( resource $handle [, int $length] );
 Description: Gets a line from file pointer
*/

// include the file.inc for common test funcitons
include ("file.inc");

$file_modes = array("w+", "w+b", "w+t",
                    "a+", "a+b", "a+t",
                    "x+", "x+b", "x+t");

$file_content_types = array("numeric", "text", "text_with_new_line", "alphanumeric");

echo "*** Testing fgets() : usage variations ***\n";

$filename = dirname(__FILE__)."/fgets_variation5.tmp";

foreach($file_modes as $file_mode) {
  echo "\n-- Testing fgets() with file opened using mode $file_mode --\n";

  foreach($file_content_types as $file_content_type) {
    echo "-- File content type : $file_content_type --\n";

    /* create files with $file_content_type */
    $file_handle = fopen($filename, $file_mode);
    $data = fill_file($file_handle, $file_content_type, 50);

    if ( !$file_handle ) {
      echo "Error: failed to open file $filename!";
      exit();
    }

    /* read with length beyong file size */
    echo "-- fgets() with length > filesize --\n";
    rewind($file_handle);

    var_dump( ftell($file_handle) );
    var_dump( fgets($file_handle, 50 + 23) ); // expected: 50
    var_dump( ftell($file_handle) ); // ensure the file pointer position
    var_dump( feof($file_handle) );  // enusre if eof set

    //close file
    fclose($file_handle);

    // delete file
    delete_file($filename);
  } // file_content_type loop
} // file_mode loop

echo "Done\n";
?>

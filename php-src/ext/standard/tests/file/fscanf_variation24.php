<?php

/*
  Prototype: mixed fscanf ( resource $handle, string $format [, mixed &$...] );
  Description: Parses input from a file according to a format
*/

/* Test fscanf() to scan strings using different char format types */

$file_path = dirname(__FILE__);

echo "*** Test fscanf(): different char format types with strings ***\n";

// create a file
$filename = "$file_path/fscanf_variation24.tmp";
$file_handle = fopen($filename, "w");
if($file_handle == false)
  exit("Error:failed to open file $filename");

// array of strings
$strings = array (
  "",
  '',
  "0",
  '0',
  "1",
  '1',
  "\x01",
  '\x01',
  "\01",
  '\01',
  'string',
  "string",
  "true",
  "FALSE",
  'false',
  'TRUE',
  "NULL",
  'null'
);

$char_formats = array( "%c",
		       "%hc", "%lc", "%Lc",
		       " %c", "%c ", "% c",
		       "\t%c", "\n%c", "%4c",
		       "%30c", "%[a-zA-Z@#$&0-9]", "%*c");

$counter = 1;

// writing to the file
foreach($strings as $string) {
  @fprintf($file_handle, $string);
  @fprintf($file_handle, "\n");
}
// closing the file
fclose($file_handle);

// opening the file for reading
$file_handle = fopen($filename, "r");
if($file_handle == false) {
  exit("Error:failed to open file $filename");
}

$counter = 1;
// reading the values from file using different char formats
foreach($char_formats as $char_format) {
  // rewind the file so that for every foreach iteration the file pointer starts from bof
  rewind($file_handle);
  echo "\n-- iteration $counter --\n";
  while( !feof($file_handle) ) {
    var_dump( fscanf($file_handle,$char_format) );
  }
  $counter++;
}

echo "\n*** Done ***";
?>

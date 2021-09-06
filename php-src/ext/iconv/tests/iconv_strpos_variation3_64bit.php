<?php
/* Prototype  : int iconv_strpos(string haystack, string needle [, int offset [, string charset]])
 * Description: Find position of first occurrence of a string within another
 * Source code: ext/iconv/iconv.c
 */

/*
 * Pass iconv_strpos different data types as $offset arg to test behaviour
 */

echo "*** Testing iconv_strpos() : usage variations ***\n";

// Initialise function arguments not being substituted
$needle = b'a';
$haystack = b'string_val';
$encoding = 'utf-8';

//get an unset variable
$unset_var = 10;
unset ($unset_var);

// get a class
class classA
{
  public function __toString() {
    return "Class A object";
  }
}

// heredoc string
$heredoc = <<<EOT
hello world
EOT;

// get a resource variable
$fp = fopen(__FILE__, "r");

// unexpected values to be passed to $offest argument
$inputs = array(

       // int data
       0,
       1,
       12345,
	   -5,
       -2345,

       // float data
       10.5,
       -9.5,
       -100.3,
       12.3456789000e10,
       12.3456789000E-10,
       .5,

       // null data
       NULL,
       null,

       // boolean data
       true,
       false,
       TRUE,
       FALSE,

       // empty data
       "",
       '',

       // string data
       "string",
       'string',
       $heredoc,

       // object data
       new classA(),

       // undefined data
       @$undefined_var,

       // unset data
       @$unset_var,

       // resource variable
       $fp
);

// loop through each element of $inputs to check the behavior of iconv_strpos()

foreach($inputs as $input) {
  echo "--\n";
  var_dump($input);
  var_dump( iconv_strpos($haystack, $needle, $input, $encoding));
};

fclose($fp);

echo "Done";
?>

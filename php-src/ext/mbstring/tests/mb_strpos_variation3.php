<?php
/* Prototype  : int mb_strpos(string $haystack, string $needle [, int $offset [, string $encoding]])
 * Description: Find position of first occurrence of a string within another
 * Source code: ext/mbstring/mbstring.c
 */

/*
 * Pass mb_strpos different data types as $offset arg to test behaviour
 */

echo "*** Testing mb_strpos() : usage variations ***\n";

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
/*1*/  0,
       1,
       12345,
	   -5,
       -2345,

       // float data
/*6*/  10.5,
       -5.5,
	   -100.5,
       12.3456789000e10,
       12.3456789000E-10,
       .5,

       // null data
/*12*/ NULL,
       null,

       // boolean data
/*14*/ true,
       false,
       TRUE,
       FALSE,

       // empty data
/*18*/ "",
       '',

       // string data
/*20*/ "string",
       'string',
       $heredoc,

       // object data
/*23*/ new classA(),

       // undefined data
/*24*/ @$undefined_var,

       // unset data
/*25*/ @$unset_var,

       // resource variable
/*26*/ $fp
);

// loop through each element of $inputs to check the behavior of mb_strpos()
$iterator = 1;
foreach($inputs as $input) {
  echo "\n-- Iteration $iterator --\n";
  var_dump( mb_strpos($haystack, $needle, $input, $encoding));
  $iterator++;
};

fclose($fp);

echo "Done";
?>

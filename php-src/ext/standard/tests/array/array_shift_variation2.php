<?php
/* Prototype  : mixed array_shift(array &$stack)
 * Description: Pops an element off the beginning of the array
 * Source code: ext/standard/array.c
 */

/*
 * Pass arrays where values are of one data type to test behaviour of array_shift()
 */

echo "*** Testing array_shift() : usage variations ***\n";


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

// arrays of different data types to be passed to $stack argument
$inputs = array(

       // int data
/*1*/  'int' => array(
	   0,
       1,
       12345,
       -2345,
       ),

       // float data
/*2*/  'float' => array(
       10.5,
       -10.5,
       12.3456789000e10,
       12.3456789000E-10,
       .5,
       ),

       // null data
/*3*/ 'null' => array(
       NULL,
       null,
       ),

       // boolean data
/*4*/ 'bool' => array(
       true,
       false,
       TRUE,
       FALSE,
       ),

       // empty data
/*5*/ 'empty string' => array(
       "",
       '',
       ),

/*6*/ 'empty array' => array(
       ),

       // string data
/*7*/ 'string' => array(
       "string",
       'string',
       $heredoc,
       ),

       // object data
/*8*/ 'object' => array(
       new classA(),
       ),

       // undefined data
/*9*/ 'undefined' => array(
       @$undefined_var,
       ),

       // unset data
/*10*/ 'unset' => array(
       @$unset_var,
       ),

       // resource variable
/*11*/ 'resource' => array(
       $fp
       ),
);

// loop through each element of $inputs to check the behavior of array_shift
$iterator = 1;
foreach($inputs as $key => $input) {
  echo "\n-- Iteration $iterator: $key data --\n";
  var_dump( array_shift($input) );
  var_dump($input);
  $iterator++;
};

fclose($fp);


echo "Done";
?>

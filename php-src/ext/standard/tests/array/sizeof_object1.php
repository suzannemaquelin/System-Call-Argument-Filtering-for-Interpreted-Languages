<?php
/* Prototype  : int sizeof($mixed var[, int $mode])
 * Description: Counts an elements in an array. If Standard PHP library is installed,
 * it will return the properties of an object.
 * Source code: ext/standard/basic_functions.c
 * Alias to functions: count()
 */

echo "*** Testing sizeof() : object functionality ***\n";

echo "-- Testing sizeof() with an object which implements Countable interface --\n";
class sizeof_class implements Countable
{
  public $member1;
  private $member2;
  protected $member3;

  public function count()
  {
    return 3; // return the count of member variables in the object
  }
}

$obj = new sizeof_class();

echo "-- Testing sizeof() in default mode --\n";
var_dump( sizeof($obj) );
echo "-- Testing sizeof() in COUNT_NORMAL mode --\n";
var_dump( sizeof($obj, COUNT_NORMAL) );
echo "-- Testing sizeof() in COUNT_RECURSIVE mode --\n";
var_dump( sizeof($obj, COUNT_RECURSIVE) );

echo "Done";
?>

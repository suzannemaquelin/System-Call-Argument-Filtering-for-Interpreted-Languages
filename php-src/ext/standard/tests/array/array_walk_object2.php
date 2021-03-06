<?php
/* Prototype  : bool array_walk(array $input, string $funcname [, mixed $userdata])
 * Description: Apply a user function to every member of an array
 * Source code: ext/standard/array.c
*/

/*
* Testing array_walk() with an array of objects
*/

echo "*** Testing array_walk() : array of objects ***\n";

/*
 * Prototype : callback(mixed $value, mixed $key, int $addvalue
 * Parameters : $value - values in given input array
 *              $key - keys in given input array
 *              $addvalue - value to be added
 * Description : Function adds the addvalue to each element of an array
*/
function callback_private($value, $key, $addValue)
{
  echo "value : ";
  var_dump($value->getValue());
  echo "key : ";
  var_dump($key);
}

function callback_public($value, $key)
{
  echo "value : ";
  var_dump($value->pub_value);
}
function callback_protected($value, $key)
{
  echo "value : ";
  var_dump($value->get_pro_value());
}

class MyClass
{
  private $pri_value;
  public $pub_value;
  protected $pro_value;
  public function __construct($setVal)
  {
    $this->pri_value = $setVal;
    $this->pub_value = $setVal;
    $this->pro_value = $setVal;
  }
  public function getValue()
  {
    return $this->pri_value;
  }
  public function get_pro_value()
  {
    return $this->pro_value;
  }
};

// array containing objects of MyClass
$input = array (
  new MyClass(3),
  new MyClass(10),
  new MyClass(20),
  new MyClass(-10)
);

echo "-- For private member --\n";
var_dump( array_walk($input, "callback_private", 1));
echo "-- For public member --\n";
var_dump( array_walk($input, "callback_public"));
echo "-- For protected member --\n";
var_dump( array_walk($input, "callback_protected"));

echo "Done"
?>

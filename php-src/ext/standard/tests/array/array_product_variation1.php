<?php
/* Prototype  : mixed array_product(array input)
 * Description: Returns the product of the array entries
 * Source code: ext/standard/array.c
 * Alias to functions:
 */

echo "*** Testing array_product() : variation - using non numeric values ***\n";

class A {
  static function help() { echo "hello\n"; }
}
$fp = fopen(__FILE__, "r");

$types = array("boolean (true)" => true, "boolean (false)" => false,
       "string" => "hello", "numeric string" =>  "12",
       "resource" => $fp, "object" => new A(), "null" => null,
       "array" => array(3,2));

foreach ($types as $desc => $type) {
  echo $desc . "\n";
  var_dump(array_product(array($type)));
  echo "\n";
}

fclose($fp);
?>
===DONE===

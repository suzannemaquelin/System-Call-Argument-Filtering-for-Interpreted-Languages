<?php
/* Prototype  : mixed prev(array $array_arg)
 * Description: Move array argument's internal pointer to the previous element and return it
 * Source code: ext/standard/array.c
 */

/*
 * Test basic functionality of prev()
 */

echo "*** Testing prev() : basic functionality ***\n";

$array = array('zero', 'one', 'two');
end($array);
echo key($array) . " => " . current($array) . "\n";
var_dump(prev($array));

echo key($array) . " => " . current($array) . "\n";
var_dump(prev($array));

echo key($array) . " => " . current($array) . "\n";
var_dump(prev($array));

echo "\n*** Testing an array with differing values/keys ***\n";
$array2 = array('one', 2 => "help", 3, false, 'stringkey2' => 'val2', 'stringkey1' => 'val1');
end($array2);
$length = count($array2);
for ($i = $length; $i > 0; $i--) {
    var_dump(prev($array2));
}

?>
===DONE===

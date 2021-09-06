<?php

$array = [1, 2, 3];
$array2 = [4, 5];
array_walk($array, function(&$value, $key) use ($array2) {
    var_dump($value);
    if ($value == 2) {
        $GLOBALS['array'] = $array2;
    }
    $value *= 10;
});
var_dump($array, $array2);

?>

<?php

$array = [1, 2, 3];
array_walk($array, function($value, $key) {
    var_dump($value);
    if ($value == 2) {
        $GLOBALS['array'] = [4, 5];
    }
});
var_dump($array);

?>

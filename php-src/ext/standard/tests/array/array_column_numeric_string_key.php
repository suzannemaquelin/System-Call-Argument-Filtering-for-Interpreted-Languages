<?php

$array = [[42 => 'a'], [42 => 'b']];
var_dump(array_column($array, 42));
var_dump(array_column($array, "42"));

?>

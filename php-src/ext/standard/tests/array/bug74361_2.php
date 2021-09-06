<?php

$array = range(0, 15);
for ($i = 0; $i <= 8; $i++) {
    unset($array[$i]);
}

foreach ($array as $x) {
    var_dump($x);
    array_rand($array, 1);
}

?>

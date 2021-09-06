<?php

$ao = new ArrayObject([1, 2, 3]);
try {
    $ao->exchangeArray(new SplFixedArray);
} catch (Exception $e) {
    echo $e->getMessage(), "\n";
}
var_dump($ao);

?>

<?php

$ao = new ArrayObject([1, 2, 3]);
$i = 0;
$ao->uasort(function($a, $b) use ($ao, &$i) {
    if ($i++ == 0) {
        var_dump($ao);
    }
    return $a <=> $b;
});

?>

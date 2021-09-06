<?php

$ao = new ArrayObject([1, 2, 3]);
$i = 0;
$ao->uasort(function($a, $b) use ($ao, &$i) {
    if ($i++ == 0) {
        $ao->exchangeArray([4, 5, 6]);
        var_dump($ao);
    }
    return $a <=> $b;
});

?>

<?php

$it = new \AppendIterator();
$it->append(new ArrayIterator(['foo']));

foreach ($it as $item) {
    var_dump($item);

    if ('foo' === $item) {
        $it->append(new ArrayIterator(['bar']));
    }
}

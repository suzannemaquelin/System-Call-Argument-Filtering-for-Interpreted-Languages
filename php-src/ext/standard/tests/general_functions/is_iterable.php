<?php

function gen() {
    yield;
}

var_dump(is_iterable([1, 2, 3]));
var_dump(is_iterable(new ArrayIterator([1, 2, 3])));
var_dump(is_iterable(gen()));
var_dump(is_iterable(1));
var_dump(is_iterable(3.14));
var_dump(is_iterable(new stdClass()));

?>

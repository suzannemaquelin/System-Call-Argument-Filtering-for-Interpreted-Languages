<?php

class foo extends SplFixedArray {
    public function __construct($size) {
    }
}

$x = new foo(2);

$z = clone $x;
echo "No crash.";

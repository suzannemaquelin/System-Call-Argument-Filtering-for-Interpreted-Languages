<?php
function foo() {
    $other = bar();

    return ["hello", $other];
}

function bar() {
    return "world";
}

foo();

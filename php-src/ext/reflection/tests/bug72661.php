<?php
function test(iterable $arg) { }

var_dump((string)(new ReflectionParameter("test", 0))->getType());
?>

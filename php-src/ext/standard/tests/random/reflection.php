<?php
$rf = new ReflectionFunction('random_bytes');
var_dump($rf->getNumberOfParameters());
var_dump($rf->getNumberOfRequiredParameters());

$rf = new ReflectionFunction('random_int');
var_dump($rf->getNumberOfParameters());
var_dump($rf->getNumberOfRequiredParameters());
?>
===DONE===

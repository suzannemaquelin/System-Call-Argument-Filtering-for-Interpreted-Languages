<?php
$rf = new ReflectionFunction('mysqli_fetch_all');
var_dump($rf->getNumberOfParameters());
var_dump($rf->getNumberOfRequiredParameters());

$rm = new ReflectionMethod('mysqli_result', 'fetch_all');
var_dump($rm->getNumberOfParameters());
var_dump($rm->getNumberOfRequiredParameters());
?>
===DONE===

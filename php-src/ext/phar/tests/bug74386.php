<?php
$r = new ReflectionMethod(Phar::class, '__construct');
var_dump($r->getNumberOfRequiredParameters());
var_dump($r->getNumberOfParameters());

$r = new ReflectionMethod(PharData::class, '__construct');
var_dump($r->getNumberOfRequiredParameters());
var_dump($r->getNumberOfParameters());
?>
===DONE===

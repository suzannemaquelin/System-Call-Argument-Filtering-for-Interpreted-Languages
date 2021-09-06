<?php
$r = new ReflectionFunction('session_start');
var_dump($r->getNumberOfParameters());
var_dump($r->getNumberOfRequiredParameters());
?>
===DONE===

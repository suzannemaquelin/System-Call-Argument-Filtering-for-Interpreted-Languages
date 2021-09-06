<?php
$rf = new ReflectionFunction('openssl_open');
var_dump($rf->getNumberOfParameters());
var_dump($rf->getNumberOfRequiredParameters());
?>
===DONE===
